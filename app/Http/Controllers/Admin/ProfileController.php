<?php
namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use App\Models\Admin;
use Redirect;
use Session;
use Image;
use Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit_profile_view() 
        {
            $admin_name= Auth::user()->admin_name ;
            $ifexist = Admin::where([
                'admin_name' => $admin_name
            ])->get();
      
            return view('admin.profile.edit_profile' , compact('ifexist'));

     }
     public function edit_profile(Request $request)
        {
         // return $image = $request->file('cat_image');
            $admin_name= Auth::user()->admin_name ;
        //  return $admin_name;
            $rules = [
                
                'admin_image' => 'required',
                'admin_name' => 'required',
            ];
            $this->validate($request, $rules);
            if($request->file('admin_image') )
                {

                    $image = $request->file('admin_image');
                    $input['imagename'] = time().'.'.$image->extension();
                
                    $filePath = public_path('/uploads/admins/thumbs');
            
                    $img = Image::make($image->path());
                    $img->resize(110, 110, function ($const) {
                        $const->aspectRatio();
                    })->save($filePath.'/'.$input['imagename']);
                
                    $filePath = public_path('/uploads/admins');
                    $image->move($filePath, $input['imagename']);
                
                    $images= $input['imagename'];
                    Admin::where('admin_name', $admin_name)
                    ->update([
                    'admin_image' =>  $images
                    ]);
                }
      
            $input = $request->input('admin_name');

        
            
            Admin::where('admin_name',$admin_name)->update(['admin_name'=> $input]);
            
            Session::flash('success', 'Profile Edited!'); 
            return redirect('/admin/profile');
        }  

    public function change_pass_view() 
        {
        
   
            return view('admin.profile.change_password' );

        }

        public function change_pass(Request $request)
    {
       
        // $rules = [
           
        //     'current_pass' => 'required',
        //     'new_pass' => 'required|confirmed',
        //     'confirm_pass' => 'required|',
        // ];
        // $this->validate($request, $rules);

        $current_pass = $request->input('current_pass'); 
        $new_pass = $request->input('new_pass');
        $confirm_pass = $request->input('confirm_pass');
// return Hash::make($current_pass);
        $admin_email= Auth::user()->admin_email;

                            $current_Password= Admin::where([
                                'admin_email' => $admin_email, 
                               
                              ])
                              ->first();
                            //   return $current_Password->password;
                              if(\Hash::check($current_pass , $current_Password->password ))
                              {
                                if($new_pass== $confirm_pass )
                                {
                                    //   return "done";
                                    $user = Admin::where('admin_email', $admin_email)
                                    ->update(['password' => bcrypt($new_pass)]);
                                }
                                else{
                                    Session::flash('success', 'Confirmed Pass not Correct');
                                return redirect()->back();
                                }
                                
                              }
                              else{
                                Session::flash('success', 'Current Password Mismatched');
                                return redirect()->back();
                              }

       
                              Auth::guard('admin')->logout();
        return redirect('/admin/login')->with('msg', 'Your password has been changed!');
    }

}
