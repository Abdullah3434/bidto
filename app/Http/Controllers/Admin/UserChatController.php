<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Redirect;
use Session;
use App\Models\ChatThread;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Storage;
 
class UserChatController extends Controller
{
    public function view_threads($id) 
        {
            $ifexist = ChatThread::where([
                'from_id' => $id
            ])->orwhere('to_id',$id)->orderby('id', 'desc')->get();
            // return $ifexist;
            if(count($ifexist)>0)
            {
                $ifexist2 = ChatMessage::where([
                    'thread_id' =>  $ifexist[0]->id
                ])->orderBy('id', 'desc')->get();
            }
           else
           {
            $ifexist2=[];
           }
           
           
            if(count($ifexist2)>0)
            {
                $last_msg= $ifexist2[0]->created_at;
            }
            else{
                $last_msg= '';
            }
                
            return view('admin.user_chat.view_thread' , compact('ifexist','last_msg'));

        }  

    public function view_chat($id,$from_id,$to_id) 
        {
           
            $ifexist = ChatMessage::with('sender','receiver')->where([
                'thread_id' => $id
            ])->get();
            //   return $ifexist;
            // $chatthread = ChatThread::all();

            // $ifexist2 = ChatMessage::where([
            //     'from_id' => $to_id
            // ])->orderBy('created_at', 'desc')->get();
            // return $ifexist;
            return view('admin.user_chat.view_chat' , compact('ifexist','from_id','to_id'));

        }  

    public function getLoadLatestMessages(Request $request,$from_id,$to_id)
        {
            //   return $request->to_id;
            
            $messages = ChatMessage::where(function($query) use ($request) {
                return "as";
                $query->where('from_id', $request->from_id)->where('to_id', $request->to_id);
            })->orWhere(function ($query) use ($request) {
                $query->where('from_id', $request->from_id)->where('to_id', $request->to_id);
            })->orderBy('created_at', 'ASC')->limit(10)->get();
            $return = [];
            foreach ($messages as $message) {
                $return[] = view('admin.user_chat.view_chat')->with('message', $message  ,'from_id', $from_id)->render();
            }
            return response()->json(['state' => 1, 'messages' => $return]);
        }

    public function delete_chat($id) 
        {
            $ifexist = ChatMessage::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Message Deleted!'); 
            return redirect()->back();

        }


}
