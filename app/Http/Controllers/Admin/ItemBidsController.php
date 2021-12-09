<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Session;
use App\Models\ItemBid; 
use App\Models\User; 
use App\Models\Item; 

class ItemBidsController extends Controller
{
    public function view_bids($id) 
        {
        
          
            $all_bids= ItemBid::where('item_id', $id)->get();
        
            return view('admin.item_bids.view_bids' , compact('all_bids'));
        } 
        public function edit_bid_view($id) 
        {
        
            $ifexist= ItemBid::find($id);

            $user= User::where('id', $ifexist->user_id)->get();
            $item= Item::where('id', $ifexist->item_id)->get();
        
            return view('admin.item_bids.edit_bid' , compact('ifexist','user','item'));
        } 

    public function status(Request $request,$id)
        {
           
            $update= ItemBid::where('id', $id)->update(['status' => $request->status]);
            Session::flash('success', 'Status '.$request->status); 
            return Redirect::back();
          
        }
    public function edit_bid(Request $request,$id)
        {

            $input = $request->input('bid_amount');

            $rules = [

                'bid_amount' => 'required',
            ];
            $this->validate($request, $rules);
            
            ItemBid::where('id',$id)->update(['bid_amount'=> $input]);
    
            Session::flash('success', 'Bid Edited!'); 
            return redirect('/admin/bids');
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
