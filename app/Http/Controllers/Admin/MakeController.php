<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\ItemMake; 
use App\Models\ItemModel;
class MakeController extends Controller
{
    public function view_item_make() 
    {
       
        $all_makes= ItemMake::orderby('id', 'desc')->get();
    
        return view('admin.item_makes.view_make' , compact('all_makes'));

    }

 public function add_item_make_view()
    {

        return view('admin.item_makes.add_make');
    }

public function add_item_make(Request $request)
    {
        $rules = [

        'make_name' => 'required',
        ];
        $this->validate($request, $rules);


        $input = $request->input('make_name');

        $data= new ItemMake;
        $data->make_name=$input;

        $data->save();   

        Session::flash('success', 'Make Name Added!'); 

        return redirect('/admin/makes');
    }

public function edit_item_make_view($id) 
    {
        $ifexist = ItemMake::find($id);
        return view('admin.item_makes.edit_make' , compact('ifexist'));

    }
public function edit_item_make(Request $request,$id)
    {

        $input = $request->input('make_name');

        $rules = [

            'make_name' => 'required',
        ];
        $this->validate($request, $rules);
        
        ItemMake::where('id',$id)->update(['make_name'=> $input]);
   
        Session::flash('success', 'Make Name Edited!'); 
        return redirect('/admin/makes');
    }

public function delete_item_make($id)
    {
        $collection = ItemMake::where('id', $id)->delete();
        $collection = ItemModel::where('make_id', $id)->delete();

        Session::flash('success', 'Make Name Deleted!'); 
        return redirect()->back();

    }

    //........................model..........................//

    public function view_item_model($make_id)
    {
        $all_models= ItemModel::where('make_id','=',$make_id )->get();
        return view('admin.item_models.view_model' , compact('all_models','make_id'));

     }

public function add_item_model_view($make_id)
    {
        $all_makes= ItemMake::all();
        return view('admin.item_models.add_model',compact('make_id','all_makes'));
     }

public function add_item_model(Request $request,$make_id)
    {
        $rules = [
        
            'model_name' => 'required',
        ];
        $this->validate($request, $rules);


        $input = $request->input('model_name');


        $data = array(
            'model_name' =>$input, 
            'make_id' =>$make_id,
            
             );
        ItemModel::insert($data);    

        Session::flash('success', 'Model Name Added!'); 

        return redirect('/admin/models/'.$make_id);
    }

public function edit_item_model_view($make_id,$model_id) 
    {

        $make_name = ItemMake::where('id', $make_id)->get();
        $ifexist = ItemModel::where('id', $model_id)->get();
        return view('admin.item_models.edit_model' , compact('ifexist','make_name','model_id'));

     }
public function edit_item_model(Request $request,$make_id,$model_id)
    {

        $input = $request->input('model_name');

        $rules = [

            'model_name' => 'required',
        ];
        $this->validate($request, $rules);
        
        ItemModel::where('id',$model_id)->update(['model_name'=> $input]);
   
        Session::flash('success', 'Model Name Edited!'); 
        return redirect('/admin/models/'.$make_id);
    }

public function delete_item_model($id) 
    {
        $ifexist = ItemModel::where([
        'id' => $id
        ])->delete();
        Session::flash('success', 'Model Name Deleted!'); 
        return redirect()->back();

    }
}
