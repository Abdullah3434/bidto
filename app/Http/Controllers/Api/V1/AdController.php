<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Carbon;
use Validator;
use Hash;
use Auth;
use File;
use Image;
use DB;
use Log;

use App\Models\Item;
use App\Models\ItemTempFile;
use App\Models\ItemPhoto;
use App\Models\User;
use App\Models\UserTransaction;
use App\Models\UserFavorite;
use App\Models\ItemBid;
use App\Models\ItemView;
use App\Models\Language;
use App\Models\Category;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
class AdController extends Controller
{
    /**
      * dashboard list with one promoted ad and active deals
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function listDashboard(Request $request)
    {
        $authenticated_user  = Auth::user();
        
        try {
            $items = Item::with('user', 'user.language', 'photos', 'category')
                            ->where('item_type', 'item')
                            ->where('promotion_end_date', '>', Carbon::now()->toDateTimeString())
                            ->where('status','active')
                            ->whereHas('user', function($q){
                                $q->where('status', 'active');
                            })
                            ->orderby( 'id', 'desc')
                            ->limit(3)
                            ->get();
        
            
            $items->map(function ($single) use ($authenticated_user){
                $is_favorite = UserFavorite::where('user_id', $authenticated_user->id)->where('item_id', $single->id)->first();
                if($is_favorite){
                    $single->is_liked = 1;
                }else{
                    $single->is_liked = 0;
                }

                $my_bid_rank = ItemBid::where('item_id', $single->id)  
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

            $data['items'] = $items;


            $promoted_item = Item::with('user', 'user.language', 'photos', 'category', 'max_bid', 'max_bid.user' , 'max_bid.user.language')
                            ->where('promotion_end_date', '>', Carbon::now()->toDateTimeString())
                            ->where('item_type', 'item')
                            ->where('status','active')
                            ->whereHas('user', function($q){
                                $q->where('status', 'active');
                            })
                            ->where('is_promoted', '1')
                            ->orderby( 'id', 'desc')
                            ->first();

            if($promoted_item){
                $my_bid_rank = ItemBid::where('item_id', $promoted_item->id)  
                ->orderby('bid_amount', 'desc')
                ->get()
                ->unique('user_id')
                ->values()
                ->all();

                $key = array_search($authenticated_user->id, collect($my_bid_rank)->map->user_id->toArray());

                if($key===false){
                    $promoted_item->my_bid_position = 0;
                }else{
                    $promoted_item->my_bid_position = $key+1;
                }
            }

            

            $data['promoted_item'] = $promoted_item;



            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $data);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }
    
    /**
      * Filter ads listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getFilterAds(Request $request)
    {
        $authenticated_user  = Auth::user();
        try {
            $items = Item::with('user', 'user.language', 'photos', 'category', 'type', 'make', 'model', 'condition', 'exterior_color', 'interior_color', 'transmission', 'cylinder', 'bids')
                            ->where('promotion_end_date', '>', Carbon::now()->toDateTimeString())
                            ->where('status','active')
                            ->whereHas('user', function($q){
                                $q->where('status', 'active');
                            });
            if(isset($request->is_selling) && $request->is_selling==1){
                $items->where('user_id',$authenticated_user->id);
            }else{
                $items->where('user_id','!=', $authenticated_user->id);
            }

            if(isset($request->search_key) && $request->search_key!=''){

                $items->whereRaw("MATCH (item_name, item_description)AGAINST('".$request->search_key."' IN BOOLEAN MODE)");

            }

            if(isset($request->type) && $request->type!=''){
                
                $items->where('item_type', $request->type);

            }
            if (isset($request->category_key) && $request->category_key != '' && $request->category_key != 'all') {

                $items->where('category_key', $request->category_key);

            }


            if(isset($request->type) && $request->type=='item'){

               
                if (isset($request->from_price) && $request->from_price != '' && isset($request->to_price) && $request->to_price != ''){

                    $items->whereBetween('item_to_price',array($request->from_price,@$request->to_price));
                }

            }else if(isset($request->type) && $request->type=='request'){

                
                if (isset($request->from_price) && $request->from_price != ''){

                    $items->whereBetween('item_from_price',array($request->from_price,@$request->to_price));
                }
                if(isset($request->to_price) && $request->to_price != ''){
    
                    $items->whereBetween('item_to_price',array(@$request->from_price,@$request->to_price));
                }
            }
            /*if (isset($request->from_price) && $request->from_price != '' && isset($request->to_price) && $request->to_price != ''){

                $items->where('item_from_price','>=', $request->from_price)->where('item_to_price','<=', $request->to_price);
            }*/

            /*if(isset($request->to_price) && $request->to_price != ''){

                $items->where('item_to_price','<=', $request->to_price);
            }*/

            if(isset($request->sort_by) && $request->sort_by != ''){
                if($request->sort_by=='high_to_low'){
                    $items->orderby('item_from_price','desc');
                    $items->orderby('item_to_price','desc');
                }else if($request->sort_by=='low_to_high'){
                    $items->orderby('item_from_price','asc');
                    $items->orderby('item_to_price','asc');
                }else if($request->sort_by=='new_items'){
                    $items->orderby('id','desc');
                }else if($request->sort_by=='high_recommended'){
                    $items->orderby( 'item_total_views', 'desc');
                }
            }else{
                $items->orderby('id','desc');
            }


            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;
           
            $items = $items->limit($limit)
                            ->offset(($page - 1) * $limit)
                            ->paginate($limit);

            $items->map(function ($single) use ($authenticated_user){
                $is_favorite = UserFavorite::where('user_id', $authenticated_user->id)->where('item_id', $single->id)->first();
                if($is_favorite){
                    $single->is_liked = 1;
                }else{
                    $single->is_liked = 0;
                }
                
                $my_bid_rank = ItemBid::where('item_id', $single->id)  
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
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $items);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }
     /**
      * ads listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getUserAd(Request $request)
    {
        $authenticated_user  = Auth::user();
        try {
            $items = Item::with('user', 'user.language', 'photos', 'category', 'type', 'make', 'model', 'condition', 'exterior_color', 'interior_color', 'transmission', 'cylinder', 'bids')                          
                            ->whereHas('user', function($q){
                                $q->where('status', 'active');
                            });
           
            if(isset($request->user_id) && $request->user_id!='' && $request->user_id!=0 ){
                $items->where('user_id', $request->user_id);
            }else{
                $items->where('user_id', $authenticated_user->id);
            }
            if(isset($request->search_key) && $request->search_key!=''){

                $items->whereRaw("MATCH (item_name, item_description)AGAINST('".$request->search_key."' IN BOOLEAN MODE)");

            }

            if(isset($request->type) && $request->type!=''){
                
                $items->where('item_type', $request->type);
                
            }
            
            if (isset($request->category_key) && $request->category_key != 0 && $request->category_key != '') {

                $items->where('category_key', $request->category_key);

            }

            if(isset($request->type) && $request->type=='item'){

               
                if (isset($request->from_price) && $request->from_price != '' && isset($request->to_price) && $request->to_price != ''){

                    $items->whereBetween('item_to_price',array($request->from_price,@$request->to_price));
                }

            }else if(isset($request->type) && $request->type=='request'){

                
                if (isset($request->from_price) && $request->from_price != ''){

                    $items->whereBetween('item_from_price',array(@$request->from_price,@$request->to_price));
                }
                if(isset($request->to_price) && $request->to_price != ''){
    
                    $items->whereBetween('item_to_price',array(@$request->from_price,@$request->to_price));
                }
            }

           /* if (isset($request->from_price) && $request->from_price != '' && isset($request->to_price) && $request->to_price != ''){

                $items->where('item_from_price','>=', $request->from_price)->orWhere('item_to_price','<=', $request->to_price);
            }*/

            /*if(isset($request->to_price) && $request->to_price != ''){

                $items->where('item_to_price','<=', $request->to_price);
            }*/

        
            if(isset($request->sort_by) && $request->sort_by != ''){
                if($request->sort_by=='high_to_low'){
                    $items->orderby('item_from_price','desc');
                    $items->orderby('item_to_price','desc');
                }else if($request->sort_by=='low_to_high'){
                    $items->orderby('item_from_price','asc');
                    $items->orderby('item_to_price','asc');
                }else if($request->sort_by=='new_items'){
                    $items->orderby('id','desc');
                }else if($request->sort_by=='high_recommended'){
                    $items->orderby( 'item_total_views', 'desc');
                }
            }else{
                $items->orderby('id','desc');
            }

            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;
           
            $items = $items->limit($limit)
                            ->offset(($page - 1) * $limit)
                            ->paginate($limit);

            $items->map(function ($single) use ($authenticated_user){
                $is_favorite = UserFavorite::where('user_id', $authenticated_user->id)->where('item_id', $single->id)->first();
                if($is_favorite){
                    $single->is_liked = 1;
                }else{
                    $single->is_liked = 0;
                }
                
                $my_bid_rank = ItemBid::where('item_id', $single->id)  
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
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $items);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }
     /**
      * Upload Temporary Image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function uploadImage(Request $request)
    {
        $authenticated_user  = @Auth::guard('api')->user();
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:jpeg,jpg,png,gif,svg'
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Upload Images after Resize
                    $image_cover = $_FILES['image']['name'];
                    $image_tmp = $_FILES['image']['tmp_name'];
                    $ext = strtolower(pathinfo($image_cover, PATHINFO_EXTENSION));
    
                    // can upload same image using rand function
                    $final_image_cover = time().'_'.$image_cover;
    
                    $large_image_path = public_path('uploads/temporary_files/'.$final_image_cover);
                    Image::make($image_tmp)->save($large_image_path);
                    $small_image_path = public_path('uploads/temporary_files/thumbs/'.$final_image_cover);
                    Image::make($image_tmp)->resize(50, 50)->save($small_image_path);
                    $input['file'] = $final_image_cover;
                }
                $input['type'] = isset($request->type)?$request->type:'ad';
                $input['item_id'] = isset($request->item_id)?$request->item_id:0;
                $input['item_file_id'] = isset($request->item_file_id)?$request->item_file_id:0;
                $input['user_id'] = isset($authenticated_user->id)?$authenticated_user->id:0;
               
                $temp_file = ItemTempFile::create($input);
                $responseMessage = Lang::get('api.Image has been saved successfully.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, $temp_file);

            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }

        }
    }

    public function purchasePromotion(Request $request){
        $authenticated_user  = Auth::user();
        try{
            $balance = settingValue('promoted_ad_cost');
            $promotion_days = settingValue('promotion_days');

            $exist_user = User::with('language')->where('id', $authenticated_user->id)->first();

            $balance = (double)@$exist_user->language->currency_value*(double)$balance;

            if( $exist_user->user_balance >= $balance){
                $remaining_balance = (double)$exist_user->user_balance-(double)$balance;

                $update_user['user_balance'] = $remaining_balance;
                $update_user['promotion_ads'] = (int)$exist_user->promotion_ads+(int)settingValue('promotion_ads');
                $update_user['promotion_days'] = settingValue('promotion_days');

                User::where('id', $authenticated_user->id)->update($update_user);

                $create_transaction['item_id'] = 0;
                $create_transaction['user_id'] = $authenticated_user->id;
                $create_transaction['amount'] = $balance;
                $create_transaction['transaction_type'] = 'purchase_promotion';
                UserTransaction::create($create_transaction);

                $data['user_balance'] = number_format($remaining_balance,2) ;

                $responseMessage = Lang::get("api.You have successfully got promotion.");
                return ApiResponse::successResponse('SUCCESS', $responseMessage, null , $data);  

            }else{
                $responseMessage = Lang::get("api.You haven't enough balance to get this promotion.");
                return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
            }
        }catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }
    /**
      * cREATE aD
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function createAd(Request $request){
         
        $authenticated_user  = Auth::user();

        $rules['item_type'] ='required|in:item,service,request';
        $rules['name'] ='required|max:191';
        $rules['description'] ='required';
        $rules['category'] ='required|exists:categories,cat_key';
        if(isset($request->item_type)){
            if($request->item_type=='item'){
                $rules['condition'] ='required|exists:item_conditions,id';
                $rules['type'] ='required|exists:item_types,type_key';
                $rules['make'] ='required|exists:item_makes,id';
                $rules['model'] ='required|exists:item_models,id';
                $rules['max_price'] = 'required|numeric';
                $rules['year'] ='required';
                //$rules['newest_year'] ='required';
                $rules['interior_color'] ='required|exists:item_colors,id';
                $rules['exterior_color'] ='required|exists:item_colors,id';
                $rules['transmission'] ='required|exists:item_transmissions,id';
                $rules['no_of_cylinders'] ='required|exists:item_cylinders,id';
            }else{
                if($request->item_type=='request'){
                    $rules['price_from'] = 'required|numeric';
                    $rules['price_to'] = 'required|numeric';
                }
            } 
        }
        $rules['location'] = 'required|max:191';
        $rules['latitude'] = 'required|max:191';
        $rules['longitude'] = 'required|max:191';
      
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try{

                $exist_user = User::with('language')->where('id', $authenticated_user->id)->first();
                if($exist_user){

                    $remaining_balance = $exist_user->user_balance;
                    $balance = 0;

                    $create_ad['item_name'] = $request->name;
                    $create_ad['item_description'] = $request->description;
                    $create_ad['item_type'] = $request->item_type;
                    $create_ad['user_id'] = $authenticated_user->id;
                    $create_ad['category_key'] = $request->category;
                    if($request->item_type=='item'){
                        $create_ad['item_condition_id'] = $request->condition;
                        $create_ad['item_type_key'] = $request->type;
                        $create_ad['item_make_id'] = $request->make;
                        $create_ad['item_model_id'] = $request->model;
                        $create_ad['item_to_price'] = $request->max_price;
                        $create_ad['item_year'] = $request->year;
                       // $create_ad['item_year_new'] = $request->newest_year;
                        $create_ad['item_interior_color_id'] = $request->interior_color;
                        $create_ad['item_exterior_color_id'] = $request->exterior_color;
                        $create_ad['item_transmission_id'] = $request->transmission;
                        $create_ad['item_cylinder_id'] = $request->no_of_cylinders;
                    }else{
                        if($request->item_type=='request'){
                            $create_ad['item_from_price'] = $request->price_from;
                            $create_ad['item_to_price'] = $request->price_to;
                        }
                        
                    }
                    $create_ad['item_location'] = isset($request->location)?$request->location:null;
                    $create_ad['item_latitude'] = isset($request->latitude)?$request->latitude:null;
                    $create_ad['item_longitude'] = isset($request->longitude)?$request->longitude:null;
                    if(isset($request->is_promotion) && $request->is_promotion==1){
                        if($exist_user->promotion_ads>0){
                            
                        }else{

                            $balance = settingValue('promoted_ad_cost');
                            $promotion_days = settingValue('promotion_days');
                
                            $balance = (double)@$exist_user->language->currency_value*(double)$balance;
                
                            if( $exist_user->user_balance >= $balance){
                                $remaining_balance = (double)$exist_user->user_balance-(double)$balance;
                
                                $update_user['user_balance'] = $remaining_balance;
                                $update_user['promotion_ads'] = (int)$exist_user->promotion_ads+(int)settingValue('promotion_ads');
                                $update_user['promotion_days'] = settingValue('promotion_days');
                
                                User::where('id', $authenticated_user->id)->update($update_user);
                
                                $create_transaction['item_id'] = 0;
                                $create_transaction['user_id'] = $authenticated_user->id;
                                $create_transaction['amount'] = $balance;
                                $create_transaction['transaction_type'] = 'purchase_promotion';
                                UserTransaction::create($create_transaction);
                
                                $data['user_balance'] = number_format($remaining_balance,2) ;
                
                                $exist_user = User::with('language')->where('id', $authenticated_user->id)->first(); 
                
                            }else{
                                $responseMessage = Lang::get("api.You haven't enough balance to get this promotion.");
                                return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                            }
                        }

                        $create_ad['is_promotion'] = $request->is_promotion;
                        $promotion_days = $exist_user->promotion_days;

                        $create_ad['item_promotion_days'] = $promotion_days;
                        $create_ad['promotion_end_date'] = Carbon::now()->addDays($promotion_days);
                        $create_ad['item_promotion_price'] = 0;
                        User::where('id', $authenticated_user->id)->update(array('promotion_ads'=>((int)$exist_user->promotion_ads-1)));

                    }else{
                        $ad_cost = settingValue('ad_cost');
                        $balance = (double)@$exist_user->language->currency_value*(double)$ad_cost;

                        if($exist_user->user_balance>=$balance){

                            $promotion_days = settingValue('ad_days');
                            $create_ad['is_promotion'] = '0';
                            $create_ad['item_promotion_days'] = $promotion_days;
                            $create_ad['promotion_end_date'] = Carbon::now()->addDays($promotion_days);
                            $create_ad['item_promotion_price'] = $balance;
                            $remaining_balance = (double)$authenticated_user->user_balance-(double)$balance;
                            User::where('id', $authenticated_user->id)->update(array('user_balance'=>$remaining_balance));

                        }else{
                           $responseMessage = Lang::get("api.You haven't enough balance to post it.");
                           return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }
                   

                    $item = Item::create($create_ad);

                    $create_ad['item_sef'] = Str::slug( $create_ad['item_name'] , '-' ).'-'.$item->id;
                    
                    Item::where('id', $item->id)->update(array('item_sef'=>$create_ad['item_sef']));
                
                    if(isset($request->item_photos) && count($request->item_photos)>0){
                        $item_photos = $request->item_photos;
                        $create_photos['item_id'] = $item->id;
                        
                        for($i=0;$i<count($item_photos); $i++){
                            $item_files = ItemTempFile::where('id', $item_photos[$i])->first();
                            
                            if($item_files){
                                if($i==0){
                                    $create_photos['is_default']='1';
                                }else{
                                    $create_photos['is_default']='0';
                                }
                                $create_photos['image'] = $item_files->file;
                                $from_path = public_path('uploads/temporary_files/'.$item_files->file);
                                $to_path = public_path('uploads/items/'.$item_files->file);
                                $from_thumb_path = public_path('uploads/temporary_files/thumbs/'.$item_files->file);
                                $to_thumb_path = public_path('uploads/items/thumbs/'.$item_files->file);;
                                File::move($from_path, $to_path);
                                File::move($from_thumb_path, $to_thumb_path);
                                ItemPhoto::create($create_photos);
                                ItemTempFile::where('id', $item_photos[$i])->delete();
                            }
                        }
                    
                    }

                    $created_item = Item::with('user', 'user.language', 'photos', 'category')->where('id', $item->id)->first();

                    $created_item->my_bid_position = 0;
               
                    if($request->item_type=='item'){
                        $responseMessage = Lang::get('api.Item has been added successfully.');
                    }else if($request->item_type=='service'){
                        $responseMessage = Lang::get('api.Service has been added successfully.');
                    }else{
                        $responseMessage = Lang::get('api.Request has been added successfully.');
                    }
                    
                   $data['user_balance'] = number_format($remaining_balance,2) ;
                   return ApiResponse::successResponse('SUCCESS', $responseMessage, $created_item, $data);  
                
                }else{
                    $responseMessage = Lang::get('api.Your account does not exist in our system.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
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
      * ads detail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getAdDetail(Request $request)
    {
        $authenticated_user  = @Auth::user();
        $rules['item_sef'] ='required|exists:items,item_sef';
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try {
              
                $items = Item::with('user','user.language', 'photos', 'type', 'make', 'model', 'condition', 'exterior_color', 'interior_color', 'transmission', 'cylinder')
                                ->where('item_sef', $request->item_sef)
                                ->where('status','active')
                                ->whereHas('user', function($q){
                                    $q->where('status', 'active');
                                })
                                ->first();

                if($items){
                    //to get authenticated user liked it or not
                    $user_item_like = UserFavorite::where('user_id',$authenticated_user->id)
                                                    ->where('item_id', $items->id)->first();
                    if($user_item_like){
                        $items->is_liked = 1;
                    }

                    $lang_key = 'en';

                    if($request->header('Accept-Language')!=''){
                        $lang_key = $request->header('Accept-Language');
                    }else{
                        $lang_key = @Auth::user()->lang_key;
                    }

                     //to get categories
                    $items->category = Category::where('cat_key', $items->category_key)->where('lang_key', $lang_key)->first();


                    //to get bids
                    $items->bids = null;
                
                    if($authenticated_user->id!=$items->user_id){
                        $items->bids =ItemBid::where('item_id', $items->id)->where('user_id',$authenticated_user->id)->get();
                    }else{
                        $items->bids =ItemBid::where('item_id', $items->id)->get();
                    }

                   //to get authenticated user bid position in bids array
                    $items->bids->map(function ($single_bid) use ($authenticated_user){
                        $my_bid_rank = ItemBid::where('item_id', $single_bid->item_id)  
                                                ->orderby('bid_amount', 'desc')
                                                ->get()
                                                ->unique('user_id')
                                                ->values()
                                                ->all();

                        $key = array_search($authenticated_user->id, collect($my_bid_rank)->map->user_id->toArray());

                        if($key===false){
                            $single_bid->my_bid_position = 0;
                        }else{
                            $single_bid->my_bid_position = $key+1;
                        }
                        return $single_bid;
                    });

                    //to get authenticated user bid position in items
                    $my_bid_rank = ItemBid::where('item_id', $items->id)  
                                            ->orderby('bid_amount', 'desc')
                                            ->get()
                                            ->unique('user_id')
                                            ->values()
                                            ->all();

                    $key = array_search($authenticated_user->id, collect($my_bid_rank)->map->user_id->toArray());

                    if($key===false){
                        $items->my_bid_position = 0;
                    }else{
                        $items->my_bid_position = $key+1;
                    }


                }

                $create_view['item_id'] = $items->id;
                $create_view['user_id'] = @$authenticated_user->id;
                ItemView::create($create_view);

                $total_view = ItemView::where('item_id',$items->id)->count();
                Item::where('id', $items->id)->update(array('item_total_views'=>$total_view));
            
                $responseMessage = Lang::get('api.Records have been found.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, $items);

            } catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
     /**
     * Like Unlike Ad
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function likeUnlike(Request $request)
    {
        $authenticated_user  = Auth::user();

        $validator = Validator::make($request->all(), [
            'item_id' => 'required|exists:items,id',
        ]);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        } else {

            try {
                //HERE Ad Like or Unlike
                $item = Item::with('user')
                            ->where('id', $request->item_id)
                            ->whereHas('user', function($q){
                                $q->where('status', 'active');
                            })
                            ->where('status', 'active')
                    ->first();
                if ($item) {
                    $likeUnlikeAd = UserFavorite::where('user_id', $authenticated_user->id)
                                                ->where('item_id', $request->item_id)
                                                ->first();
                    if ($likeUnlikeAd) {

                        $likeUnlikeAd->delete();
                        
                        $data['is_liked'] = 0;
                        $responseMessage = Lang::get('api.Item has been unliked successfully.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, $data);

                    } else {

                        UserFavorite::create(array('user_id' => $authenticated_user->id, 'item_id' => $request->item_id));

                        $data['is_liked'] = 1;
                        $responseMessage = Lang::get('api.Item has been liked successfully.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, $data);
                    }
                } else {
                    $responseMessage = Lang::get('api.You can not like/unlike this ad.');
                    return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
                }

            } catch (\Exception $e) {
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }

    }
    /**
      * favorite ads listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getMyFavorites(Request $request)
    {
        $authenticated_user  = Auth::user();
        
        try {
            $items = UserFavorite::with('user', 'user.language', 'item', 'item.user', 'item.photos', 'item.category')
                                    ->where('user_id', $authenticated_user->id)
                                    ->whereHas('user', function($q){
                                        $q->where('status', 'active');
                                    })
                                    ->whereHas('item', function($q){
                                        $q->where('status', 'active')
                                        ->whereHas('user', function($q){
                                            $q->where('status', 'active');
                                        });
                                    });
                                    
            
            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;
           
            $items = $items->orderby('id', 'desc')
                            ->limit($limit)
                            ->offset(($page - 1) * $limit)
                            ->paginate($limit);

            $items->map(function ($single) use ($authenticated_user){
               $single->item->is_liked=1;

               $my_bid_rank = ItemBid::where('item_id', $single->id)  
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
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $items);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }

     /**
      *  purchase history listing
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getPurchaseHistory(Request $request)
    {
        $authenticated_user  = Auth::user();
        
        try {
            $items = ItemBid::with('user', 'user.language', 'item', 'item.user', 'item.photos', 'item.category')
                                    ->where('user_id', $authenticated_user->id)
                                    ->where('status', 'approved')
                                    ->whereHas('user', function($q){
                                        $q->where('status', 'active');
                                    })
                                    ->whereHas('item', function($q){
                                        $q->where('status', 'active')
                                        ->whereHas('user', function($q){
                                            $q->where('status', 'active');
                                        });
                                    });

            
            $page  = $request->has('page') ? $request->get('page') : 1;
            $limit = $request->has('limit') ? $request->get('limit') : 10;
           
            $items = $items->orderby('id', 'desc')
                            ->limit($limit)
                            ->offset(($page - 1) * $limit)
                            ->paginate($limit);

            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $items);

        } catch (\Exception $e) {
            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }

    /**
     * delete Ad
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteAd(Request $request)
    {
        $authenticated_user = Auth::user();
        $validator = Validator::make($request->all(), [
            'ad_id'=> 'required|exists:items,id'
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                //DELETE ITEM

                $item = Item::where('id', $request->ad_id)->where('user_id',$authenticated_user->id)->first();
                if($item){
                    Item::where('id', $request->ad_id)->delete();

                    $photos = ItemPhoto::where('item_id', $request->ad_id)->get();
                    foreach($photos as $single_photo){
                        File::delete(public_path('uploads/items/' . $single_photo->image));
                        File::delete(public_path('uploads/items/thumbs/' . $single_photo->image));
                        $single_photo->delete();
                    }
                    $responseMessage = Lang::get('api.Selected ad has been deleted.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }else{
                    $responseMessage = Lang::get('api.You can not delete it.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                }
            
            }catch(\Exception $e){
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }


     /**
     * delete Temp Image
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function deleteTempImage(Request $request)
    {
        $authenticated_user = Auth::user();
        $validator = Validator::make($request->all(), [
            'image_id'=> 'required',
            'image_key' => 'required|in:temp,permanent',
        ]);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                //DELETE ITEM Temp Images
                if($request->image_key=='temp'){
                    $item_temp_files = ItemTempFile::where('id', $request->image_id)->first();
                
                    if($item_temp_files){
                        File::delete(public_path('uploads/temporary_files/' . $item_temp_files->file));
                        File::delete(public_path('uploads/temporary_files/thumbs/' . $item_temp_files->file));
                        ItemTempFile::where('id', $request->image_id)->delete();
                        $responseMessage = Lang::get('api.Selected image has been deleted.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                    }else{
                        $responseMessage = Lang::get('api.You can not delete it.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                    }
                }else{
                    $item_temp_files = ItemPhoto::where('id', $request->image_id)->first();
                
                    if($item_temp_files){
                        File::delete(public_path('uploads/items/' . $item_temp_files->file));
                        File::delete(public_path('uploads/items/thumbs/' . $item_temp_files->file));
                        ItemPhoto::where('id', $request->image_id)->delete();
                        $responseMessage = Lang::get('api.Selected image has been deleted.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                    }else{
                        $responseMessage = Lang::get('api.You can not delete it.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                    }
                }
               
            
            }catch(\Exception $e){
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }


    /**
      * EXTEND dAYS
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function extendDays(Request $request){
         
        $authenticated_user  = Auth::user();

        $rules['item_sef'] ='required|exists:items,item_sef';
      
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try{

                $exist_user = User::with('language')->where('id', $authenticated_user->id)->first();
                if($exist_user){
                    $exist_item = Item::where('item_sef', $request->item_sef)->first();
                    if($exist_item){
                        $remaining_balance = $exist_user->user_balance;
                        $balance = 0;
                        if(isset($request->is_promotion) && $request->is_promotion==1){
                            if($exist_user->promotion_ads>0){
                                
                            }
                            else{
    
                                $balance = settingValue('promoted_ad_cost');
                                $promotion_days = settingValue('promotion_days');
                    
                                $balance = (double)@$exist_user->language->currency_value*(double)$balance;
                    
                                if( $exist_user->user_balance >= $balance){
                                    $remaining_balance = (double)$exist_user->user_balance-(double)$balance;
                    
                                    $update_user['user_balance'] = $remaining_balance;
                                    $update_user['promotion_ads'] = (int)$exist_user->promotion_ads+(int)settingValue('promotion_ads');
                                    $update_user['promotion_days'] = settingValue('promotion_days');
                    
                                    User::where('id', $authenticated_user->id)->update($update_user);
                    
                                    $create_transaction['item_id'] = 0;
                                    $create_transaction['user_id'] = $authenticated_user->id;
                                    $create_transaction['amount'] = $balance;
                                    $create_transaction['transaction_type'] = 'purchase_promotion';
                                    UserTransaction::create($create_transaction);
                    
                                    $data['user_balance'] = number_format($remaining_balance,2) ;
                    
                                    $exist_user = User::with('language')->where('id', $authenticated_user->id)->first(); 
                    
                                }else{
                                    $responseMessage = Lang::get("api.You haven't enough balance to get this promotion.");
                                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                                }
                            }
    
                            $extend_ad['is_promotion'] = $request->is_promotion;
                            $promotion_days = $exist_user->promotion_days;
    
                            $extend_ad['item_promotion_days'] = $promotion_days;
                            if($exist_item->promotion_end_date>Carbon::now()){
                                $extend_ad['promotion_end_date'] = Carbon::parse($exist_item->promotion_end_date)->addDays($promotion_days);
                            }else{
                                $extend_ad['promotion_end_date'] = Carbon::now()->addDays($promotion_days);
                            }
                            
                            $extend_ad['item_promotion_price'] = 0;
                            User::where('id', $authenticated_user->id)->update(array('promotion_ads'=>((int)$exist_user->promotion_ads-1)));
    
                        }else{
                            $ad_cost = settingValue('ad_cost');
                            $balance = (double)@$exist_user->language->currency_value*(double)$ad_cost;
    
                            if($exist_user->user_balance>=$balance){
    
                                $promotion_days = settingValue('ad_days');
                                $extend_ad['is_promotion'] = '0';
                                $extend_ad['item_promotion_days'] = $promotion_days;
                                $extend_ad['promotion_end_date'] = Carbon::now()->addDays($promotion_days);
                                $extend_ad['item_promotion_price'] = $balance;
                                $remaining_balance = (double)$authenticated_user->user_balance-(double)$balance;
                                User::where('id', $authenticated_user->id)->update(array('user_balance'=>$remaining_balance));
    
                            }else{
                               $responseMessage = Lang::get("api.You haven't enough balance to post it.");
                               return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                            }
                        }

                        Item::where('id', $exist_item->id)->update($extend_ad);

                        $created_item = Item::with('user', 'user.language', 'photos', 'category')->where('id', $exist_item->id)->first();

                        if($created_item){
                            $my_bid_rank = ItemBid::where('item_id', $created_item->id)  
                                                ->orderby('bid_amount', 'desc')
                                                ->get()
                                                ->unique('user_id')
                                                ->values()
                                                ->all();

                            $key = array_search($authenticated_user->id, collect($my_bid_rank)->map->user_id->toArray());

                            if($key===false){
                                $created_item->my_bid_position = 0;
                            }else{
                                $created_item->my_bid_position = $key+1;
                            }
                        }
                        if($exist_item->item_type=='item'){
                            $responseMessage = Lang::get('api.Item has been extended successfully.');
                        }else if($exist_item->item_type=='service'){
                            $responseMessage = Lang::get('api.Service has been extended successfully.');
                        }else{
                            $responseMessage = Lang::get('api.Request has been extended successfully.');
                        }
                        
                       $data['user_balance'] = number_format($remaining_balance,2) ;
                       return ApiResponse::successResponse('SUCCESS', $responseMessage, $created_item, $data); 
                    }else{
                        $responseMessage = Lang::get('api.Requested Ad does not exist in our system.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                   
                }else{
                    $responseMessage = Lang::get('api.Your account does not exist in our system.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
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
      * edit aD
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function editAd(Request $request){
         
        $authenticated_user  = Auth::user();

        $rules['item_sef'] ='required|exists:items,item_sef';
        $rules['name'] ='required|max:191';
        $rules['description'] ='required';
        $rules['category'] ='required|exists:categories,cat_key';
        if(isset($request->item_type)){
            if($request->item_type=='item'){
                $rules['condition'] ='required|exists:item_conditions,id';
                $rules['type'] ='required|exists:item_types,type_key';
                $rules['make'] ='required|exists:item_makes,id';
                $rules['model'] ='required|exists:item_models,id';
                $rules['max_price'] = 'required|numeric';
                $rules['year'] ='required';
                //$rules['newest_year'] ='required';
                $rules['interior_color'] ='required|exists:item_colors,id';
                $rules['exterior_color'] ='required|exists:item_colors,id';
                $rules['transmission'] ='required|exists:item_transmissions,id';
                $rules['no_of_cylinders'] ='required|exists:item_cylinders,id';
            }else{
                if($request->item_type=='request'){
                    $rules['price_from'] = 'required|numeric';
                    $rules['price_to'] = 'required|numeric';
                }
            } 
        }
        $rules['location'] = 'required|max:191';
        $rules['latitude'] = 'required|max:191';
        $rules['longitude'] = 'required|max:191';
      
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else {
            try{

                $exist_user = User::with('language')->where('id', $authenticated_user->id)->first();
                if($exist_user){
                    $exist_item = Item::where('item_sef', $request->item_sef)->first();
                    if($exist_item){
                            $remaining_balance = $exist_user->user_balance;
                            $balance = 0;

                            $update_ad['item_name'] = $request->name;
                            $update_ad['item_description'] = $request->description;
                            $update_ad['category_key'] = $request->category;
                            if($exist_item->item_type=='item'){
                                $update_ad['item_condition_id'] = $request->condition;
                                $update_ad['item_type_key'] = $request->type;
                                $update_ad['item_make_id'] = $request->make;
                                $update_ad['item_model_id'] = $request->model;
                                $update_ad['item_to_price'] = $request->max_price;
                                $update_ad['item_year'] = $request->year;
                            // $update_ad['item_year_new'] = $request->newest_year;
                                $update_ad['item_interior_color_id'] = $request->interior_color;
                                $update_ad['item_exterior_color_id'] = $request->exterior_color;
                                $update_ad['item_transmission_id'] = $request->transmission;
                                $update_ad['item_cylinder_id'] = $request->no_of_cylinders;
                            }else{
                                if($exist_item->item_type=='request'){
                                    $update_ad['item_from_price'] = $request->price_from;
                                    $update_ad['item_to_price'] = $request->price_to;
                                }
                                
                            }
                            $update_ad['item_location'] = isset($request->location)?$request->location:null;
                            $update_ad['item_latitude'] = isset($request->latitude)?$request->latitude:null;
                            $update_ad['item_longitude'] = isset($request->longitude)?$request->longitude:null;
                            

                            $item = Item::where('id', $exist_item->id)->update($update_ad);

                            //$create_ad['item_sef'] = Str::slug( $create_ad['item_name'] , '-' ).'-'.$item->id;
                            
                            //Item::where('id', $item->id)->update(array('item_sef'=>$create_ad['item_sef']));
                        
                            if(isset($request->item_photos) && count($request->item_photos)>0){
                                $item_photos = $request->item_photos;
                                $create_photos['item_id'] = $exist_item->id;
                                
                                for($i=0;$i<count($item_photos); $i++){
                                    $item_files = ItemTempFile::where('id', $item_photos[$i])->first();
                                    
                                    if($item_files){
                                        if($i==0){
                                            $create_photos['is_default']='1';
                                        }else{
                                            $create_photos['is_default']='0';
                                        }
                                        $create_photos['image'] = $item_files->file;
                                        $from_path = public_path('uploads/temporary_files/'.$item_files->file);
                                        $to_path = public_path('uploads/items/'.$item_files->file);
                                        $from_thumb_path = public_path('uploads/temporary_files/thumbs/'.$item_files->file);
                                        $to_thumb_path = public_path('uploads/items/thumbs/'.$item_files->file);;
                                        File::move($from_path, $to_path);
                                        File::move($from_thumb_path, $to_thumb_path);
                                        ItemPhoto::create($create_photos);
                                        ItemTempFile::where('id', $item_photos[$i])->delete();
                                    }
                                }
                            
                            }

                            $updated_item = Item::with('user', 'user.language', 'photos', 'category')->where('id', $exist_item->id)->first();

                            $my_bid_rank = ItemBid::where('item_id', $updated_item->id)  
                                                ->orderby('bid_amount', 'desc')
                                                ->get()
                                                ->unique('user_id')
                                                ->values()
                                                ->all();

                            $key = array_search($authenticated_user->id, collect($my_bid_rank)->map->user_id->toArray());

                            if($key===false){
                                $updated_item->my_bid_position = 0;
                            }else{
                                $updated_item->my_bid_position = $key+1;
                            }
                            
                            if($exist_item->item_type=='item'){
                                $responseMessage = Lang::get('api.Item has been updated successfully.');
                            }else if($exist_item->item_type=='service'){
                                $responseMessage = Lang::get('api.Service has been updated successfully.');
                            }else{
                                $responseMessage = Lang::get('api.Request has been updated successfully.');
                            }
                            
                        $data['user_balance'] = number_format($remaining_balance,2) ;
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, $updated_item, $data);  
                    }else{
                        $responseMessage = Lang::get('api.Requested Ad does not exist in our system.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                        
                }else{
                    $responseMessage = Lang::get('api.Your account does not exist in our system.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                } 
                  
            }catch (\Exception $e) {
                //QUERY EXCEPTION
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
     }
}