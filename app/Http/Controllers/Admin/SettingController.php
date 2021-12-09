<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\Setting;

class SettingController extends Controller
{
    public function view_settings() 
        {

            $all_settings= Setting::all();
          
            return view('admin.settings.edit_settings' , compact('all_settings'));

        }
   
    public function edit_setting(Request $request)
        {

            
            // $rules = [
            //     'setting' => 'required',
            // ];
            // $this->validate($request, $rules);  

            $input = $request->all();
            //  return $input;

             $all_settings= Setting::all();
             foreach($all_settings as $single_setting)
             {
                $update['value'] = $input[$single_setting->key];
                Setting::where('key', $single_setting->key)->update($update);
                
             }

       

            // Setting::query()->update(['va' => $input['site_is_down'],'login_attempts' => $input['login_attempts'] ]);

            Session::flash('success', 'Setting Updated!'); 
            return redirect('/admin/settings');
        }

        
   


}
