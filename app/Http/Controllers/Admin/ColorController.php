<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\ItemColor;  
use App\Models\Language;
class ColorController extends Controller
{
    public function view_color() 
        {
        
            $all_color= ItemColor::orderby('id', 'desc')->get();
        
            return view('admin.color.view_color' , compact('all_color'));

        }

    public function add_color_view()
        {
            
            return view('admin.color.add_color');
        }

    public function add_color(Request $request)
        {
            $rules = [
                
                'color_name' => 'required',
            ];
            $this->validate($request, $rules);
            
            
            $input = $request->input('color_name');


            $data = array(
            'color_name' =>$input, 
                
            );
            ItemColor::insert($data);    
    
        Session::flash('success', 'Color Added!'); 
    
        return redirect('/admin/color/');
        }

    public function edit_color_view($id) 
        {
            $ifexist = ItemColor::find($id);
    
            return view('admin.color.edit_color' , compact('ifexist'));

        }
    public function edit_color(Request $request,$id)
        {
    
            $input = $request->input('color_name');

            $rules = [

                'color_name' => 'required',
            ];
            $this->validate($request, $rules);
            
            ItemColor::where('id',$id)->update(['color_name'=> $input]);
            
            Session::flash('success', 'Color Edited!'); 
            return redirect('/admin/color/');
        }

    public function delete_color($id) 
        {
            $ifexist = ItemColor::where([
                    'id' => $id
            ])->delete();
            Session::flash('success', 'Color Deleted!'); 
            return redirect()->back();

        }
}
