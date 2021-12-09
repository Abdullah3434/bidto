<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Hesto\MultiAuth\Traits\LogsoutGuard;
use Redirect;
use Session;
use App\Models\User; 
use App\Models\UserTransaction;
use App\Models\UserReview;
use Illuminate\Support\Facades\Storage;
use Image;

class ManageUserController extends Controller
{
    public function view_users() 
        {
       
            $all_users= User::orderby('id', 'desc')->get();
        // return $all_users;
            return view('admin.users.view_user' , compact('all_users'));

        }
    public function status($status,$id)
        {
           
            if($status=='active')
                {
                
                    $status='in_active';
            
                }
            elseif($status=='in_active')
                {
                
                    $status='active';
                }
                if($status=='in_active')
                {
                    $message='In Active';
                }
                elseif($status=='active')
                {
                    $message='Active';
                }

            $update= User::where('id', $id)->update(['status' => $status]);
            Session::flash('success', 'Status '.$message); 
            return Redirect::back();
          
        }

    public function verify($status,$id)
        {
           
            if($status=='0')
                {
                    $status='1';
                }
            elseif($status=='1')
                {
                    $status='0';
                }
                if($status=='0')
                {
                    $message='Not Verified';
                }
                elseif($status=='1')
                {
                    $message='Verified';
                }


            $update= User::where('id', $id)->update(['is_verified' => $status]);
            Session::flash('success', 'Status '.$message);  
            return Redirect::back();
          
        }

    public function edit_user_view($id) 
        {
     
            $ifexist = User::where([
                        'id' => $id
                        ])->first();

            $lang_keys = User::select('*')
            ->where('lang_key', '=', $ifexist->lang_key)
            ->get();
            
                if($lang_keys[0]->lang_key=='en')
                    {
                        $lang_key='ar';
                    }
                else
                    {
                        $lang_key='en';
                    }
            
            return view('admin.users.edit_user' , compact('ifexist','lang_keys','lang_key'));

        }

    public function edit_user(Request $request,$id)
        {
            if($request->file('user_image') )
            {

            $image = $request->file('user_image');
            $input['imagename'] = time().'.'.$image->extension();
         
            
            $img = Image::make($image->path());
           
       
            $filePath = public_path('/uploads');
            $image->move($filePath, $input['imagename']);
       
            $images= $input['imagename'];
            // return $images;
            User::where('id', $id)
            ->update([
           'user_image' =>  $images
            ]);
            }
 
            $user_name = $request->input('user_name');
            $user_phone = $request->input('user_phone');
            $user_emails = $request->input('user_email');
            $lang_key = $request->input('lang_key');
        
            $ifexist = User::where([
                'id' => $id
                ])->first();
        
                if($ifexist->user_email==$user_emails)
                {
                    $user_email = $request->input('user_email');
                }
                else{
                    $ifexist2 = User::where([
                        'user_email' => $user_emails
                        ])->get();
                        if(count($ifexist2)>0)
                        {
                            Session::flash('success', 'User Already Added'); 
                            return redirect()->back();
                        }else{
                            $user_email = $request->input('user_email');
                        }
                }
               

            $rules = [

                'user_name' => 'required',
                'user_phone' => 'required',
                'user_email' => 'required|email',
            ];
            $this->validate($request, $rules);
            
            User::where('id',$id)->update(
                [
                    'user_name'=> $user_name,
                    'user_phone'=> $user_phone,
                    'user_email'=> $user_email,
                    'lang_key'=> $lang_key,
                ]);
           
            Session::flash('success', 'User Edited!'); 
            return redirect('/admin/users/');
        }

    public function delete_user($id) 
        {
            $ifexist = User::where([
            'id' => $id
             ])->delete();

            $collection = UserTransaction::where('user_id', $id)->delete();
            $collection = UserReview::where('from_id', $id)->delete();
            Session::flash('success', 'User Deleted!'); 
            return redirect()->back();

  
        }


}
