<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\EmailTemplate;

class EmailController extends Controller
{
    public function view_email_templates() 
        {

            $all_temp= EmailTemplate::orderby('id', 'desc')->get();

            return view('admin.email_templates.view_email_template' , compact('all_temp'));

        }
    public function edit_email_templates_view($id) 
        {
            $ifexist = EmailTemplate::find($id);
            
            return view('admin.email_templates.edit_email_temp' , compact('ifexist'));

        }

    public function edit_email_template(Request $request,$id)
        {

            $rules = [
        
                'email_name' => 'required',
                'email_subject' => 'required',
                'email_content' => 'required',
            
            ];
            $this->validate($request, $rules);  

            $input = $request->all();

            $update['email_name'] = $input['email_name'];
            $update['email_subject'] = $input['email_subject'];
            $update['email_content'] = $input['email_content'];
        
            EmailTemplate::where('id', $id)->update($update);
        
    

            Session::flash('success', 'Email Template Edited!'); 
            return redirect('/admin/email/templates');
        }
}
