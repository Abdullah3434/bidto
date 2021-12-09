<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Models\ItemCylinder; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;

class CylinderController extends Controller
{
    public function view_cylinder() 
        {
        
            $all_cylinders= ItemCylinder::orderby('id', 'desc')->get();
        
            return view('admin.item_cylinder.view_cylinder' , compact('all_cylinders'));

        }

    public function add_cylinder_view()
        {

            return view('admin.item_cylinder.add_cylinder');
        }

    public function add_cylinder(Request $request)
    {
            $rules = [
            
                'cylinder_name' => 'required',
            ];
            $this->validate($request, $rules);

            $input = $request->input('cylinder_name');
            $data = array(
                'item_cylinder' =>$input, 
                
                );
            ItemCylinder::insert($data);    

            Session::flash('success', 'Cylinder Added!'); 

            return redirect('/admin/cylinder');
        }

    public function edit_cylinder_view($id) 
        {
            $ifexist = ItemCylinder::find($id);
            return view('admin.item_cylinder.edit_cylinder' , compact('ifexist'));

        }
    public function edit_cylinder(Request $request,$id)
        {

            $input = $request->input('cylinder_name');

            $rules = [

                'cylinder_name' => 'required',
            ];
            $this->validate($request, $rules);
            
            ItemCylinder::where('id',$id)->update(['item_cylinder'=> $input]);
    
            Session::flash('success', 'Cylinder Edited!'); 
            return redirect('/admin/cylinder');
        }

    public function delete_cylinder($id) 
        {

            $ifexist = ItemCylinder::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Cylinder Deleted!'); 
            return redirect()->back();

        }

}
