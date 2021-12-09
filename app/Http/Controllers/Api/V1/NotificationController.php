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

use App\Models\UserNotification;
class NotificationController extends Controller
{
    /**
     * get notification List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getNotification(Request $request)
    {
        $authenticated_user = Auth::user();
        try {
            //GET CHAT MESSAGES
            $array = [];
            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;

            $notifications = UserNotification::with('item','from_user')
                                            ->where('to_id', $authenticated_user->id)
                                            ->whereHas('item', function($q1){
                                                $q1->where('status', 'active');
                                            });
            if(isset($request->type) && $request->type=='buyer'){
                $notifications->where('type', 'approve_bid');
            }else{
                $notifications->where('type', 'new_bid');
            }

            $notifications   =  $notifications->whereDate('created_at', '=', Carbon::today()->toDateString())->orderBy('id', 'desc')->get();

            if(count($notifications)>0){
                $data['section_title'] = "Today";
                $data['notification_count'] = count($notifications);
                $data['list']['data'] = $notifications;
                $array[] = $data;
            }
          
            $notifications = UserNotification::with('item','from_user')
                                            ->where('to_id', $authenticated_user->id)
                                            ->whereHas('item', function($q1){
                                                $q1->where('status', 'active');
                                            });
            if(isset($request->type) && $request->type=='buyer'){
                $notifications->where('type', 'approve_bid');
            }else{
                $notifications->where('type', 'new_bid');
            }

            $notifications   =  $notifications->whereDate('created_at', '=', Carbon::yesterday()->toDateString())->orderBy('id', 'desc')->get();
            
            if(count($notifications)>0){
                $data['section_title'] = "Yesterday";
                $data['notification_count'] = count($notifications);
                $data['list']['data'] = $notifications;
                $array[] = $data;
            }
        

            $notifications = UserNotification::with('item','from_user')
                                            ->where('to_id', $authenticated_user->id)
                                            ->whereHas('item', function($q1){
                                                $q1->where('status', 'active');
                                            });
            if(isset($request->type) && $request->type=='buyer'){
                $notifications->where('type', 'approve_bid');
            }else{
                $notifications->where('type', 'new_bid');
            }

            $notifications   =  $notifications->whereDate('created_at', '<', Carbon::yesterday()->toDateString())->orderBy('id', 'desc')
                                            ->limit($limit)
                                            ->offset(($page - 1) * $limit)
                                            ->paginate($limit);

            if(count($notifications)>0){
                $data['section_title'] = "Older";
                $data['notification_count'] = count($notifications);
                $data['list']['data'] = $notifications;
                $array[] = $data;
            }
            
                   
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $array);


        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }
     /**
     * delete Notification
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteNotification(Request $request)
    {
        $authenticated_user = Auth::user();
        $validator = Validator::make($request->all(), [
            'notification_id'=> 'required|exists:user_notifications,id'
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                //GET Notification

                $notification = UserNotification::where('id', $request->notification_id)->where('user_id',$authenticated_user->id)->first();
                if($notification){
                    UserNotification::where('id', $request->notification_id)->delete();
                    $responseMessage = Lang::get('api.Selected notification has been deleted.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }else{
                    $responseMessage = Lang::get('api.You can not delete it.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }

            }catch(\Exception $e){
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
  
}
