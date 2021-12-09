<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Models\ItemCondition; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
class ConditionController extends Controller
{
    public function view_condition() 
        {
        
            $all_condition= ItemCondition::orderby('id', 'desc')->get();

            return view('admin.item_condition.view_condition' , compact('all_condition'));

        }

    public function add_condition_view()
        {

            return view('admin.item_condition.add_condition');
        }

    public function add_condition(Request $request)
        {
            $rules = [

            'condition_name' => 'required',
            ];
            $this->validate($request, $rules);


            $input = $request->input('condition_name');
            $data = array(
                'condition_name' =>$input, 
                    );
            ItemCondition::insert($data);    

            Session::flash('success', 'Condition Added!'); 

            return redirect('/admin/condition');
        }

    public function edit_condition_view($id) 
        {
            $ifexist = ItemCondition::find($id);

            return view('admin.item_condition.edit_condition' , compact('ifexist'));

        }
    public function edit_condition(Request $request,$id)
        {

            $input = $request->input('condition_name');

            $rules = [

                'condition_name' => 'required',
            ];
            $this->validate($request, $rules);
            
            ItemCondition::where('id',$id)->update(['condition_name'=> $input]);
    
            Session::flash('success', 'Condition Edited!'); 
            return redirect('/admin/condition');
        }

    public function delete_condition($id) 
        {
            $ifexist = ItemCondition::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Condition Deleted!'); 
            return redirect()->back();

        }
}
