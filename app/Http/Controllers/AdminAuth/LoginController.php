<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Illuminate\Http\Request;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogsoutGuard {
        LogsoutGuard::logout insteadof AuthenticatesUsers;
    }

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
        $this->middleware('admin.guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        
        $rules = [
           
            'email' => 'required|email',
            'password' => 'required',
        ];
        $this->validate($request, $rules);

        if(Auth::guard('admin')->attempt(['admin_email' => $request->input('email'),
         'password' => $request->input('password')])){ 
           
            $admin = Auth::guard('admin'); 
        
           
            return redirect('/admin/home');
           
           
        }

       else{
        return redirect()->back()->with('success', 'Credentials  does not  Match');
        
       
        }

        
    }

    public function logout() {
        Auth::guard('admin')->logout();
  
        return redirect('/admin/login');
      }

      public function admin_home() {
        $admin = Auth::guard('admin'); 
  
        return view('admin.home');
      }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
}
