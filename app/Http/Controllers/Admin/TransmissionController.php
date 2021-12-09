<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Models\ItemTransmission; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;

class TransmissionController extends Controller
{
    public function view_transmission() 
        {
        
            $all_transmission= ItemTransmission::orderby('id', 'desc')->get();
        
            return view('admin.transmission.view_transmission' , compact('all_transmission'));

        }     

    public function add_transmission_view()
        {

            return view('admin.transmission.add_transmission');
        }

    public function add_transmission(Request $request)
        {
            $rules = [
            
                'transmission_name' => 'required',
            ];
            $this->validate($request, $rules);
            $input = $request->input('transmission_name');
            $data = array(
                'transmission_name' =>$input, 
                
                        );
            ItemTransmission::insert($data);    

            Session::flash('success', 'Transmission Added!'); 

            return redirect('/admin/transmission/');
        }

    public function edit_transmission_view($id) 
        {
            $ifexist = ItemTransmission::find($id);

            return view('admin.transmission.edit_transmission' , compact('ifexist'));

        }
    public function edit_transmission(Request $request,$id)
        {

            $input = $request->input('transmission_name');

            $rules = [

                'transmission_name' => 'required',
                    ];
            $this->validate($request, $rules);
            
            ItemTransmission::where('id',$id)->update(['transmission_name'=> $input]);
    
            Session::flash('success', 'Transmission Edited!'); 
            return redirect('/admin/transmission/');
        }

    public function delete_transmission($id) 
        {
            $ifexist = ItemTransmission::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Transmission Deleted!'); 
            return redirect()->back();

        }
}
