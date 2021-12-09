<?php


namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Image;
use App\Models\User;
use App\Models\Item;

class DashboardController extends Controller
{
    public function view_cylinder() 
        {
        return "ass";
            $all_users= User::all();
            count($all_users);
        
            return view('admin.home',compact('count'));

        }
}
