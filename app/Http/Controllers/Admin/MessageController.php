<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\MessageTemplate;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function view_message_templates() 
        {

        $all_messages= MessageTemplate::orderby('id', 'desc')->get();
    
        return view('admin.message_templates.view_message_template' , compact('all_messages'));

        }
    public function edit_message_templates_view($id) 
        {
        $ifexist = MessageTemplate::find($id);
      
        return view('admin.message_templates.edit_message_template' , compact('ifexist'));

        }

    public function edit_message_template(Request $request,$id)
        {

            $rules = [
        
                'name' => 'required',
                'message_template' => 'required',
            
            ];
            $this->validate($request, $rules);  

            $input = $request->all();

            //$message_key = Str::slug($input['name'], '_');

            $update['name'] = $input['name'];
            $update['message_template'] = $input['message_template'];
           // $update['key'] = $message_key;
        
        
            MessageTemplate::where('id', $id)->update($update);
        
    

            Session::flash('success', 'Message Template Edited!'); 
            return redirect('/admin/message/templates');
        }

        
}
