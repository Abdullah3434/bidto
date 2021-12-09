<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Support\Carbon;
use Hash;
use Auth;
use File;

use App\Models\ItemBid;
use App\Models\Item;
use App\Models\UserFavorite;
class BidController extends Controller
{
     /**
     * add Bid
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addBid(Request $request)
    {
        $authenticated_user  = Auth::user();
         
        $rules['item_id'] ='required|exists:items,id';
        $rules['amount'] ='required';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try{
                $exist_item = Item::where('id', $request->item_id)
                                    ->where('user_id', $authenticated_user->id)
                                    ->first();
                if($exist_item){
                    $responseMessage = Lang::get('api.You can not do bid on your own item.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }else{
                    $exist_item = Item::where('id', $request->item_id)->first();
                    
                    if($exist_item->item_type!='item'){
                        $responseMessage = Lang::get('api.You can not do bid on this ad.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    $exist_bid = ItemBid::where('user_id', $authenticated_user->id)
                                        ->where('item_id', $request->item_id)
                                        ->first();
                    /*if($exist_bid){
                        $responseMessage = Lang::get('api.You have already done bid on it.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }else{*/
                        $create_bid['item_id'] = $request->item_id;
                        $create_bid['user_id'] = $authenticated_user->id;
                        $create_bid['bid_amount'] = $request->amount;
                        $bid = ItemBid::create($create_bid);

                        $item_bid = ItemBid::with('item')->where('id', $bid->id)->first();
                        self::sendNotification($item_bid, 'new_bid', 0);
                        $responseMessage = Lang::get('api.You have successfully created bid.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                   // }
                }
                
            }catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
    /**
     * bid listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getMyBid(Request $request)
    {
        $authenticated_user  = Auth::user();
       
        try {
            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;
           
            $bids = ItemBid::with('item', 'item.user', 'item.category', 'item.photos' , 'user', 'user.language')->where('user_id', $authenticated_user->id)
                                ->whereHas('user', function($q){
                                    $q->where('status', 'active');
                                }) 
                                ->whereHas('item', function($q){
                                    $q->where('status', 'active')
                                    ->whereHas('user', function($q1){
                                        $q1->where('status', 'active');
                                    });
                                })                    
                                ->orderby('id', 'desc')
                                ->limit($limit)
                                ->offset(($page - 1) * $limit)
                                ->paginate($limit);


            $bids->map(function ($single) use ($authenticated_user){
                $is_favorite = UserFavorite::where('user_id', $authenticated_user->id)->where('item_id', $single->item_id)->first();
                if($is_favorite){
                    $single->item->is_liked = 1;
                }else{
                    $single->item->is_liked = 0;
                }
                
                $my_bid_rank = ItemBid::where('item_id', $single->item_id)  
                                        ->orderby('bid_amount', 'desc')
                                        ->get()
                                        ->unique('user_id')
                                        ->values()
                                        ->all();

                $key = array_search($authenticated_user->id, collect($my_bid_rank)->map->user_id->toArray());

                if($key===false){
                    $single->my_bid_position = 0;
                }else{
                    $single->my_bid_position = $key+1;
                }
                return $single;
            });

            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $bids);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }

    /**
     * pending bid listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getPendingBid(Request $request)
    {
        $authenticated_user  = Auth::user();
        $rules['item_id'] ='required|exists:items,id';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
                $page  = $request->has('page') ? $request->get('page') : 1;
                $limit = $request->has('limit') ? $request->get('limit') : 10;

                
                $bids = ItemBid::with('user', 'user.language', 'item', 'item.photos', 'item.category')
                                    ->where('item_id', $request->item_id)
                                    ->where('status','pending')
                                    ->orderby('id', 'desc')
                                    ->limit($limit)
                                    ->offset(($page - 1) * $limit)
                                    ->paginate($limit);

                $responseMessage = Lang::get('api.Records have been found.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, $bids);

            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
    
    /**
     * approved bid listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getApprovedBid(Request $request)
    {
        $authenticated_user  = Auth::user();
        $rules['item_id'] ='required|exists:items,id';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
                $page  = $request->has('page') ? $request->get('page') : 1;
                $limit = $request->has('limit') ? $request->get('limit') : 10;
                
                $bids = ItemBid::with('user', 'user.language', 'item', 'item.photos', 'item.category')
                                    ->where('item_id', $request->item_id)
                                    ->where('status','approved')
                                    ->orderby('id', 'desc')
                                    ->limit($limit)
                                    ->offset(($page - 1) * $limit)
                                    ->paginate($limit);

                $responseMessage = Lang::get('api.Records have been found.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, $bids);

            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }

    /**
     * delete bid listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteBid(Request $request)
    {
        $authenticated_user  = Auth::user();
        $rules['bid_id'] ='required|exists:item_bids,id';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
               
                $exist_bid = ItemBid::where('id', $request->bid_id)->first();
                if($exist_bid){
                    ItemBid::where('id', $request->bid_id)->delete();

                    $responseMessage = Lang::get('api.Bid has been deleted successfully.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }else{
                    $responseMessage = Lang::get('api.You can not delete it.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }

     /**
     * approve bid listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function approveBid(Request $request)
    {
        $authenticated_user  = Auth::user();
        $rules['bid_id'] ='required|exists:item_bids,id';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
               
                $exist_bid = ItemBid::with('item')
                                    ->where('id', $request->bid_id)
                                    ->whereHas('item',function ($q) use ($authenticated_user){
                                        $q->where([['user_id', $authenticated_user->id]]);
                                    })
                                    ->first();
                if($exist_bid){
                    ItemBid::where('id', $request->bid_id)->update(array('status'=>'approved'));

                    self::sendNotification($exist_bid, 'approve_bid', 0);
                    $responseMessage = Lang::get('api.Bid has been approved successfully.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }else{
                    $responseMessage = Lang::get('api.You can not approve it.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
}