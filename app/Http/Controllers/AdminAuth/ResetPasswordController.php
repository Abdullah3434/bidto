<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

use App\Models\Admin;
use Hash;
use App\Models\AdminPasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo = '/home';


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
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token)
    {
        return view('admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        // $request->validate([
        //     'admin_email' => 'required|email|exists:admins',
        //     'password' => 'required|string|min:6|confirmed',
        //     'password_confirmation' => 'required'
        // ]);
        $rules = [
           
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ];
        $this->validate($request, $rules);

        $email = $request->input('email'); 
        $password = $request->input('password');
        $c_password = $request->input('password_confirmation');

      

                            $updatePassword= AdminPasswordReset::where([
                                'email' => $email, 
                                'token' => $request->token
                              ])
                              ->first();
// return $updatePassword;
        if(!$updatePassword){
            return back()->withInput()->with('success', 'Email does not exist!');
        }

        $user = Admin::where('admin_email', $email)
                    ->update(['password' => Hash::make($password)]);
                    $email_delete= AdminPasswordReset::where(['email'=> $email])->delete();
       

        return redirect('/admin/login')->with('msg', 'Your password has been changed!');
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

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
