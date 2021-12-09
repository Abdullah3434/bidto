<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use App\Models\Admin;
use DB;
use Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        
            $rules = [

                    'admin_email' => 'required|email|exists:admins',

            ];
            $this->validate($request, $rules);

            $email = $request->input('admin_email');
            $ifexist= Admin::Where('admin_email', $email)->first();

            if($ifexist)
            {
                $admin_name= $ifexist->admin_name;
                $token = Str::random(64);

                DB::table('admin_password_resets')->insert([
                    'email' => $email, 
                    'token' => $token, 
                    'created_at' => now() 
                ]);

                $email_temp= EmailTemplate::Where('email_name', "Forgot Password for Admin")->first();
                // return $email_temp;
                $email_body= $email_temp->email_content;

                $url = route('reset.password.get', $token);

                $find_array = ['{user_name}', '{here}'];
                $rep_array = ["$admin_name", '<a href="'.$url.'"> Reset </a>'];
                $email_body = str_replace($find_array, $rep_array, $email_body);

                $email_data['email_to'] = $email;
                $email_data['email_subject'] = $email_temp->email_subject;
                $email_data['email_message'] = $email_body;

                EmailTemplate::sendEmail($email_data);
                return redirect('/admin/login')->with('msg', 'We have e-mailed your password reset link!');
             
            }
            else{
                return redirect('/admin/login')->with('msg', 'We dont have such email in our record');
               
            }
    
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }
}
