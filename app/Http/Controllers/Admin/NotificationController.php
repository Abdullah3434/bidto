<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\NotificationTemplate;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function view_notification_templates() 
        {
   
            $all_notifications=  NotificationTemplate::orderby('id', 'desc')->get();
        
            return view('admin.notification_templates.view_notification_template' , compact('all_notifications'));

        }
    public function edit_notification_template_view($id) 
        {
            $ifexist = NotificationTemplate::find($id);
          
            return view('admin.notification_templates.edit_notification_template' , compact('ifexist'));

        }

    public function edit_notification_templates(Request $request,$id)
        {
  
            $rules = [
        
                'notification_name' => 'required',
                'notification_content' => 'required',
            
            ];
            $this->validate($request, $rules);  

            $input = $request->all();

            //$notification_key = Str::slug($input['notification_name'], '_');
   
            $update['notification_name'] = $input['notification_name'];
            $update['notification_content'] = $input['notification_content'];
            //$update['notification_key'] = $notification_key;
           
           
            NotificationTemplate::where('id', $id)->update($update);
          
      

            Session::flash('success', 'Notification Template Edited!'); 
            return redirect('/admin/notification/templates');
        }

}
