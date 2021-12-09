<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use Response;
use App\Models\Item; 
use App\Models\ItemMake; 
use App\Models\ItemModel;
use App\Models\Category;
use App\Models\ItemType; 
use App\Models\ItemCondition;
use App\Models\ItemTransmission;
use App\Models\ItemCylinder; 
use App\Models\ItemColor;  
use App\Models\ItemPhoto;
use App\Models\ItemBid;
use App\Models\User;
use DB;

class ItemController extends Controller
{
    public function view_item() 
        {
        
            
            $all_items = Item::where([
                'item_type' => "item"
            ])->orderby('id', 'desc')->get();
        // return $all_items;
            return view('admin.items.view_items' , compact('all_items'));
        }   

      

        public function view_requests() 
        {
        
            $all_items = Item::where([
                'item_type' => "request"
            ])->get();
        
            return view('admin.items.view_items' , compact('all_items'));
        }  
        
    public function view_images($id) 
        {
            $all_images = ItemPhoto::where([
                'item_id' => $id
            ])->get();
        
            return view('admin.items.view_images' , compact('all_images'));
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

            $update= Item::where('id', $id)->update(['status' => $status]);
            Session::flash('success', 'Status '.$message); 
            return Redirect::back();
          
        }

    public function edit_item_view($id) 
        {

            $ifexist = Item::find($id);
            $is_promotion = Item::select('*')
            ->where('is_promotion', '!=', $ifexist->is_promotion)
            ->get();
           

            if(count($is_promotion)>0)
                {
                    $is_promotion= $is_promotion[0]->is_promotion;
                }
            else
                {
                    $is_promotion= '';
                }
            

            $is_promoted = Item::select('*')
            ->where('is_promoted', '!=', $ifexist->is_promoted)
            ->get();
            // return $is_promoted;
            if(count($is_promoted)>0)
                {
                    $is_promoted= $is_promoted[0]->is_promoted;
                }
            else
                {
                    $is_promoted= '';
                }
            
        //........make.........//
            $all_make = ItemMake::select('*')
                ->where('id', '!=', $ifexist->item_make_id)
                ->get();
            $find_make = ItemMake::where([
                'id' => $ifexist->item_make_id
                ])->get();
                // return $find_make;
                if(count($find_make)>0)
                {
                    $find_makee=$find_make[0]->make_name;
                    $find_make_id=$find_make[0]->id;
                }
            else
                {
                    $find_makee='';
                    $find_make_id='';
                }
               
        // .........model.........//
            $find_model = ItemModel::where([
                'id' => $ifexist->item_model_id
                ])->get();
                if(count($find_model)>0)
                {
                    $find_model_name=$find_model[0]->model_name;
                    $find_model_id=$find_model[0]->id;
                }
            else
                {
                    $find_model_name='';
                    $find_model_id=' ';
                }
               
      
            $all_model = ItemModel::select('*')
                ->where('id', '!=', $ifexist->item_model_id)->where('make_id', '=', $ifexist->item_make_id)
                ->get();
            //    return $all_model;
        // ....... Category ...........//
            $find_cat = Category::where([
                'lang_key' => 'en'
                ])->where('cat_key',$ifexist->category_key )->get();
                // return  $find_cat;
                if(count($find_cat)>0)
                {
                    $find_cat=$find_cat[0]->cat_key;
                }
            else
                {
                    $find_cat= '';
                }
                $all_cat = Category::select('*')
                ->where('lang_key', '=', 'en')
                ->where('cat_key', '!=', $ifexist->category_key)
                ->get();
  
         //...........Item Type.............//  
            $all_type = ItemType::select('*')
                ->where('lang_key', '=', 'en')
                ->where('type_key', '!=', $ifexist->item_type_key)
                ->get();
                
            $find_type = ItemType::where([
                    'lang_key' => 'en'
                ])->where('type_key',$ifexist->item_type_key )->get();
                if(count($find_type)>0)
                {
                    $find_type=$find_type[0]->type_key;
                }else{
                    $find_type='';
                }
                
                // return $find_type;
        //........... Item Condition.........//
            $all_condition = ItemCondition::select('*')
                ->where('id', '!=', $ifexist->item_condition_id)
                ->get();

            $find_condition = ItemCondition::where([
            ])->where('id',$ifexist->item_condition_id)->get();
            if(count($find_condition)>0)
                {
                    $find_condition_name=$find_condition[0]->condition_name;
                    $find_condition_id=$find_condition[0]->id;
                }
            else
                {
                    $find_condition_name='';
                    $find_condition_id='';
                }

           
        //........... Item Transmission.........//
            $all_trans = ItemTransmission::select('*')
            ->where('id', '!=', $ifexist->item_transmission_id)
            ->get();

            $find_trans = ItemTransmission::where([
            ])->where('id',$ifexist->item_transmission_id)->get();
            if(count($find_trans)>0)
                {
                    $find_trans_name=$find_trans[0]->transmission_name;
                    $find_trans_id=$find_trans[0]->id;
                }
            else
                {
                    $find_trans_name='';
                    $find_trans_id='';
                }
        //........... Item Cylinder.........//
            $all_cylinder = ItemCylinder::select('*')
            ->where('id', '!=', $ifexist->item_cylinder_id)
            ->get();

            $find_cylinder = ItemCylinder::where([
            ])->where('id',$ifexist->item_cylinder_id)->get();
            if(count($find_cylinder)>0)
                {
                    $find_cylinder_name=$find_cylinder[0]->item_cylinder;
                    $find_cylinder_id=$find_cylinder[0]->id;
                }
            else
                {
                    $find_cylinder_name='';
                    $find_cylinder_id='';
                }

            // //........... Item Color.........//
            $all_color_interior = ItemColor::select('*')
            ->where('id', '!=', $ifexist->item_interior_color_id)
            ->get();

            $find_interior_color = ItemColor::where([
            ])->where('id',$ifexist->item_interior_color_id)->get();
            if(count($find_interior_color)>0)
                {
                    $find_interior_color_name=$find_interior_color[0]->color_name;
                    $find_interior_color_id=$find_interior_color[0]->id;
                }
            else
                {
                    $find_interior_color_name='';
                    $find_interior_color_id='';
                }

                
                $all_color_exterior = ItemColor::select('*')
                ->where('id', '!=', $ifexist->item_exterior_color_id)
                ->get();
            $find_exterior_color = ItemColor::where([
                ])->where('id',$ifexist->item_exterior_color_id)->get();
            if(count($find_exterior_color)>0)
                {
                    $find_exterior_color_name=$find_exterior_color[0]->color_name;
                    $find_exterior_color_id=$find_exterior_color[0]->id;
                }
            else
                {
                    $find_exterior_color_name='';
                    $find_exterior_color_id='';
                }
           
            return view('admin.items.edit_item' , compact('ifexist','find_makee','find_make_id','is_promoted','is_promotion','all_color_exterior','find_exterior_color_name','find_exterior_color_id',
            'all_color_interior','find_interior_color_name','find_interior_color_id','all_type','find_type','all_make','find_make',
            'all_condition','find_condition_name','find_condition_id','find_cylinder_name','find_cylinder_id','all_cylinder','all_trans','find_trans_name','find_trans_id',
            'find_cat','find_model_name','find_model_id','all_model','all_cat'));

        }
        public function myformAjax(Request $request)
        {
          
            $value = $request->Input('cat_id');
            $model = ItemModel::select('*')
            ->where('make_id', '=', $value)
            ->get();
            return Response::json($model);
        }
 
    public function edit_item(Request $request,$id,$type)
        {
            // return $type;
         
        if($type=='item')
            {
                $rules = [

                    'category_key' => 'required',
                    'item_name' => 'required',
                    'item_description' => 'required',
                    'is_promotion' => 'required',
                    'promotion_end_date' => 'required',
                    'item_location' => 'required',
                    'item_to_price' => 'required',
                    'item_type_key' => 'required',
                    'item_make_id' => 'required',
                    'item_model_id' => 'required',
                    'item_condition_id' => 'required',
                    'item_exterior_color_id' => 'required',
                    'item_interior_color_id' => 'required',
                    'item_transmission_id' => 'required',
                    'item_cylinder_id' => 'required',

                  
                   
                ];
                $this->validate($request, $rules);

                $input = $request->all();


                // return $input['item_model_id'];
                $update['item_name'] = $input['item_name'];
                $update['item_description'] = $input['item_description'];
                $update['is_promotion'] = $input['is_promotion'];
                $update['promotion_end_date'] = $input['promotion_end_date'];
                $update['category_key'] = $input['category_key'];
                $update['item_to_price'] = $input['item_to_price'];
                $update['item_from_price'] = '0';
                $update['item_type_key'] = $input['item_type_key'];
                $update['item_make_id'] = $input['item_make_id'];
                $update['item_model_id'] =$input['item_model_id'];
                $update['item_condition_id'] = $input['item_condition_id'];
                $update['item_exterior_color_id'] = $input['item_exterior_color_id'];
                $update['item_interior_color_id'] = $input['item_interior_color_id'];
                $update['item_transmission_id'] = $input['item_transmission_id'];
                $update['item_cylinder_id'] = $input['item_cylinder_id'];
                $update['item_year'] = $input['item_year'];
                $update['item_location'] = $input['item_location'];

                Item::where('id', $id)->update($update); 

                }


            
            Session::flash('success', 'Item Edited!'); 
            return redirect('/admin/items');
        }

    public function delete_item($id) 
        {
            $ifexist = Item::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Item Deleted!'); 
            return redirect()->back();
    
        }
    public function delete_image($id) 
        {
            $ifexist = ItemPhoto::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Photo Deleted!'); 
            return redirect()->back();
    
        }


    //............................bid.............................//

    public function view_bids($id) 
        {
        
          
            $all_bids= ItemBid::where('item_id', $id)->orderby('created_at', 'desc')->get();
        
            return view('admin.items.view_bids' , compact('all_bids'));
        } 
    public function edit_bid_view($id) 
        {
        
            $ifexist= ItemBid::find($id);

            $user= User::where('id', $ifexist->user_id)->get();
            $item= Item::where('id', $ifexist->item_id)->get();
        
            return view('admin.items.edit_bid' , compact('ifexist','user','item'));
        } 

    public function bid_status(Request $request,$id)
        {
           
            $update= ItemBid::where('id', $id)->update(['status' => $request->status]);
            $status= $request->status;
            if($status=='pending')
            {
                $message='Pending';
            }
            elseif($status=='approved')
            {
                $message='Approved';
            } 
            elseif($status=='not_approved')
            {
                $message='Not Approved';
            }
            Session::flash('success', 'Status '.$message); 
            return Redirect::back();
          
        }
    public function edit_bid(Request $request,$id,$item_id)
        {

            // return $item_id;
            $input = $request->input('bid_amount');

            $rules = [

                'bid_amount' => 'required',
            ];
            $this->validate($request, $rules);
            
            ItemBid::where('id',$id)->update(['bid_amount'=> $input]);
    
            Session::flash('success', 'Bid Edited!'); 
            return redirect('/admin/item/bids/'.$item_id);
        }

    public function delete_bid($id) 
        {
            $ifexist = ItemBid::where([
            'id' => $id
            ])->delete();
            Session::flash('success', 'Bid Deleted!'); 
            return redirect()->back();
    
        }


}
