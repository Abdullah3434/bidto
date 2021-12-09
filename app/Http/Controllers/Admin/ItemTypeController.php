<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Models\ItemType; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Illuminate\Support\Str;
use App\Models\Language;

class ItemTypeController extends Controller
{
    public function add_item_type_view(Request $request)
    {
        $language =  Language::where('status', 'active')->get();
        return view('admin.item_type.add_item_type' , compact('language'));
    }
    
 
    public function add_item_type(Request $request)
    {
        $input = $request->all();
 
        $language =  Language::where('status', 'active')->get();
 
        $type_key = Str::slug($input['type_name_en'], '-');
        if($language->isNotEmpty()){
             foreach($language as $single_language){
                $rules = [
          
                    'type_name_'.$single_language->lang_key => 'required',
                ];
                $this->validate($request, $rules);
                 if($request->has('type_name_'.$single_language->lang_key)){
                     $data = array(
                        'type_name' =>$input['type_name_'.$single_language->lang_key], 
                        'type_key' =>  $type_key,
                        'lang_key' => $single_language->lang_key,
                   
                          );
                          ItemType::insert($data);    
                 }
             }
         }
         
 
        Session::flash('success', 'Item Type Added!'); 
        return redirect('/admin/item-types');
    }
 
        
public function view_item_type() 
    {
        $all_types = ItemType::select("*")
        ->where("lang_key", "=", "en")->orderby('id', 'desc')
        ->get();
        return view('admin.item_type.view_item_type' , compact('all_types'));
 
    }

public function edit_item_type_view($type_key) 
    {
        $ifexist = ItemType::where([
                 'type_key' => $type_key
                    ])->get();

        $language =  Language::where('status', 'active')->get();
         
        return view('admin.item_type.edit_item_type' , compact('ifexist','language'));
 
    }
 
 
public function edit_item_type(Request $request,$key)
    {

        $input = $request->all();
  
        $language =  Language::where('status', 'active')->get();
        if($language->isNotEmpty()){
                foreach($language as $single_language){
                    $rules = [
         
                        'type_name_'.$single_language->lang_key => 'required',
                    ];
                }
              }
        $this->validate($request, $rules);

        $item_types = ItemType::where('type_key', $key)->get();
        $item_types_lang_array = [];
            foreach($item_types as $single_item)
                {
                  $item_types_lang_array[] = $single_item->lang_key;
                } 
              if($language->isNotEmpty()){
                foreach($language as $single_language){     
                    if(in_array($single_language->lang_key,$item_types_lang_array)){
                        $update['type_name'] = $input['type_name_'.$single_language->lang_key];
                        ItemType::where('type_key', $key)->where('lang_key',$single_language->lang_key )->update($update);
                    }else{
                        $create['type_name'] = $input['type_name_'.$single_language->lang_key];
                        $create['type_key'] = $key;
                        $create['lang_key'] = $single_language->lang_key;
                        ItemType::create($create);
                    }
        
                }
            }
               
       
        Session::flash('success', 'Item Type Edited!'); 
        return redirect('/admin/item-types');
    }
 
public function delete_item_type($type_key) 
    {
        $ifexist = ItemType::where([
                     'type_key' => $type_key
                    ])->delete();
        Session::flash('success', 'Item Type Deleted!');
        return redirect()->back();
   
    }


}
