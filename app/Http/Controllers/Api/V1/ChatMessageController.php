<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Support\Carbon;
use Hash;
use Auth;
use File;

use App\Models\Item;
use App\Models\ChatThread;
use App\Models\ChatMessage;
use App\Models\User;
class ChatMessageController extends Controller
{
     /**
     * Chat Messages
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function sendChatMessage(Request $request)
    {

        $authenticated_user = Auth::user();
        $validator = Validator::make($request->all(), [
            'item_id'=> 'required',
            'datetime' => 'required',
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                //SEND MESSAGE
                $input = $request->all();

                $item = Item::with('user')
                                ->where('id', $input['item_id'])
                                ->whereHas('user', function($q){
                                    $q->where('status', 'active');
                                })
                                ->where('status', 'active')
                                ->first();
                if($item){
                    $alread_thread =ChatThread::where(function ($q) use ($authenticated_user, $input){
                        $q->where('from_id', $authenticated_user->id)
                            ->where('item_id', $input['item_id']);
                    })->orWhere(function($q1) use ($authenticated_user,$input){
                        $q1->where('to_id', $authenticated_user->id)
                            ->where('item_id', $input['item_id']);
                    })->first();

                    if($alread_thread){

                        $create_message['thread_id']      = $alread_thread->id;

                    }else{
                        if($item->user_id!=$authenticated_user->id){
                            $threads['to_id'] =  $item->user_id;
                            $threads['from_id'] = $authenticated_user->id;
                            $threads['item_id'] = $input['item_id'];
                            $dt = new \DateTime($request->datetime); // <== instance from another API
                            $carbon = Carbon::instance($dt);
                            $threads['created_at'] = $carbon->toDateTimeString();
                            $threads['updated_at'] =$carbon->toDateTimeString();
                            $alread_thread = ChatThread::create($threads);
                            $create_message['thread_id'] = $alread_thread->id;
                        }else{
                            $responseMessage = Lang::get('api.You can not send message.');
                            return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }

                    $create_message['item_id'] = $input['item_id'];

                    if($authenticated_user->id == $alread_thread->from_id){
                        $create_message['to_id'] = $alread_thread->to_id;
                        $create_message['from_id'] = $alread_thread->from_id;
                    }else{
                        $create_message['to_id'] = $alread_thread->from_id;
                        $create_message['from_id'] = $alread_thread->to_id;
                    }

                    if(isset($request->message) && $request->message!=''){
                        $create_message['message'] = trim($request->message);
                    }

                    $dt = new \DateTime($request->datetime); // <== instance from another API
                    $carbon = Carbon::instance($dt);
                    $create_message['created_at'] = $carbon->toDateTimeString();
                    $create_message['updated_at'] =$carbon->toDateTimeString();

                    $chat_message = ChatMessage::create($create_message);
                    ChatThread::where('id', $create_message['thread_id'] )->update(array('updated_at' => $carbon->toDateTimeString()));

                    self::sendNotification($chat_message, 'new_message', 0);

                    $responseMessage = Lang::get('api.Message has been sent successfully.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, $chat_message);
                }else{
                    $responseMessage = Lang::get('api.You can not send message.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
    /**
     * get Thread List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getThread(Request $request)
    {
        $authenticated_user = Auth::user();
        try {
            //GET CHAT MESSAGES

            $chat_messages = ChatThread::with('item','last_message')
                ->whereHas('item', function($q1){
                    $q1->where('status', 'active');
                })
                ->where(function ($q4) use ($authenticated_user){
                    $q4->where('from_id',$authenticated_user->id)
                       ->orWhere('to_id', '=', $authenticated_user->id);
                })
                ->orderBy('updated_at', 'desc')
                ->get();


               $chat_messages->map(function ($single) use($authenticated_user){
                    $single->user =null;
                    if($single->from_id == $authenticated_user->id){
                        $single->user = User::where('id', $single->to_id)->first();
                    }else{
                        $single->user = User::where('id', $single->from_id)->first();
                    }
                    $chat_messages_count = ChatMessage::where('thread_id', $single->id)
                                            ->where('to_id', $authenticated_user->id)
                                            ->where('is_read', 0)
                                            ->count();
                    $single->unread_messages =$chat_messages_count;
                    return $single;
               });
            $chat_messages_arr = $chat_messages->toArray();
            
            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;

            $chat_messages_array = self::paginate($chat_messages_arr, $limit, $page);
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $chat_messages_array);


        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

     /**
     * get Message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getMessages(Request $request)
    {
        $authenticated_user = Auth::user();
        $validator = Validator::make($request->all(), [
            'item_id'=> 'required',
            'thread_id' => 'required',
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
                //GET CHAT MESSAGES
                $input = $request->all();
                $thread_id = 0;

                $data['item'] = null;
                $data['user'] = null;
                $data['messages'] = null;

                $item = Item::where('id', $input['item_id'])
                            ->where('status', 'active')
                            ->first();
                if($item){
                    $data['item'] = $item;


                    if($item->user_id != $authenticated_user->id){
                        $data['user'] = User::where('id', $item->user_id)->first();
                    }else{
                        $data['user'] = User::where('id', $authenticated_user->id)->first();
                    }

                   
                    $thread_id =0 ;
                    $alread_thread =ChatThread::where(function ($q) use ($authenticated_user, $input){
                                            $q->where('from_id', $authenticated_user->id)
                                                ->where('item_id', $input['item_id']);
                                            })->orWhere(function($q1) use ($authenticated_user,$input){
                                                $q1->where('to_id', $authenticated_user->id)
                                                    ->where('item_id', $input['item_id']);
                                            })
                                            ->where('id', $input['thread_id'])
                                            ->first();

                    if($alread_thread) {

                        $thread_id = $alread_thread->id;

                        if($alread_thread->from_id == $authenticated_user->id){
                            $data['user'] = User::where('id', $alread_thread->to_id)->first();
                        }else{
                            $data['user'] = User::where('id', $alread_thread->from_id)->first();
                        }
                    }

                    $chat_messages = ChatMessage::with('sender')
                                                ->where('thread_id', $thread_id);

                    if(isset($request->os) && $request->os=='web'){
                        $chat_messages = $chat_messages->orderBy('id', 'asc')->get();
                    }else{
                        $page  = $request->has('page') ? $request->get('page') : 1;
                        $limit = $request->has('limit') ? $request->get('limit') : 10;

                        $chat_messages = $chat_messages->orderBy('id', 'desc')
                                                        ->limit($limit)
                                                        ->offset(($page - 1) * $limit)
                                                        ->paginate($limit);
                    }

                    ChatMessage::where('thread_id', $thread_id)
                                    ->where('to_id', $authenticated_user->id)
                                    ->update(array('is_read'=>1));

                    $chat_messages_count = ChatMessage::where('thread_id', $thread_id)
                                                        ->where('to_id', $authenticated_user->id)
                                                        ->where('is_read', 0)
                                                        ->count();

                    $data['messages'] =$chat_messages;
                    $extra_param['unread_messages'] = $chat_messages_count;
                    $responseMessage = Lang::get('api.Records have been found.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, $data, $extra_param);


                }else{
                    $responseMessage = Lang::get('api.You can not get message.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }

            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

     /**
     * delete Message
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteMessage(Request $request)
    {
        $authenticated_user = Auth::user();
        $validator = Validator::make($request->all(), [
            'message_id'=> 'required',
            'thread_id' => 'required',
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                //GET CHAT MESSAGES

                $chat_messages =  ChatMessage::where('thread_id', $request->thread_id)
                                                ->where('id', $request->message_id)
                                                ->where('from_id', $authenticated_user->id)
                                                ->first();
                if($chat_messages){
                    $chat_detail_msg = $chat_messages;
                    $chat_messages->delete();
                    self::sendNotification($chat_messages, 'new_message', 1);
                    $responseMessage = Lang::get('api.Selected message has been deleted.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }else{
                    $responseMessage = Lang::get('api.You can not delete it.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }

            }catch(\Exception $e){
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
  
    /**
     * get Thread List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getThreadId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_id'=> 'required',
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            $authenticated_user = Auth::user();
            try {
                //GET CHAT MESSAGES
                $chat_messages = ChatThread::with('item', 'from_user', 'to_user')
                    ->where('item_id', $request->ad_id)
                    ->whereHas('item', function ($q1) use ($authenticated_user) {
                        $q1->where('status', 'active')
                            ->where('user_id', '!=', $authenticated_user->id);
                    })
                    ->whereHas('from_user', function ($q2) {
                        $q2->where('status', 'active');
                    })
                    ->whereHas('to_user', function ($q3) {
                        $q3->where('status', 'active');
                    })
                    ->where(function ($q4) use ($authenticated_user) {
                        $q4->where('from_id', $authenticated_user->id)
                            ->orWhere('to_id', '=', $authenticated_user->id);
                    })
                    ->orderBy('updated_at', 'desc')
                    ->first();
                    $data['thread_id'] = 0;
                    if($chat_messages){
                        $data['thread_id'] = $chat_messages->id;
                    }
                $responseMessage = Lang::get('api.Records have been found.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, $data);


            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
}
