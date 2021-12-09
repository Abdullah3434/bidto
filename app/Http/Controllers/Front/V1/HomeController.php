<?php

namespace App\Http\Controllers\Front\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      // $this->middleware('user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(session()->get('login_token')){
            return view('front.home.home');
        }else{
            return redirect('/login');
        }
    }
}
