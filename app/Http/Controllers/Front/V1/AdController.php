<?php

namespace App\Http\Controllers\Front\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class AdController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the filter ajax ads page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    function filterAjaxAds(Request $request){

        
        $result_array = [];
        $login_token='';

        $url = url('/public/api/v1/filter_ads');
        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Authorization: Bearer '.$login_token
        ];
        $page = $request->page_no;
        $url.='?page='.$page;
        $postFields =[];
 
        if(isset($request->type) && $request->type!=''){
            $postFields['type'] = $request->type;
        }

        if(isset($request->is_selling) && $request->is_selling!=''){
            $postFields['is_selling'] = $request->is_selling;
        }

        if(isset($request->sort) && $request->sort!=''){
            $postFields['sort_by'] = $request->sort;
        }

        if(isset($request->category) && $request->category!=''){
            $postFields['category_key'] = $request->category;
        }

        if(isset($request->key) && $request->key!=''){
            $postFields['search_key'] = $request->key;
        }

        
        if(isset($request->is_range_move) && $request->is_range_move==1){
            if(isset($request->from) && $request->from!=''){
                $postFields['from_price'] = $request->from;
            }
            if(isset($request->to) && $request->to!=''){
                $postFields['to_price'] = $request->to;
            }
        }


        $postFields['os'] = 'web';
 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
       // print_r($response);exit;
        $response_a = json_decode($response);
       
        $result_array = @$response_a->data;
 
        if(isset($request->page_type) && $request->page_type=='ad'){
            return response()->json([
                'data' => view('front/ads/ajax_ads')->with('data',$result_array)->render()
            ]);
           
        }else{
            return response()->json([
                'data' => view('front/home/ajax_home_ads')->with('data',$result_array)->render()
            ]);
        }
       
    }

    /**
     * Show the  ads page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adView(){
        return view('front.ads.ad');
    }

    /**
     * Show the  ads detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adDetail(Request $request){
        $ad_key = '';
        if(isset($request->key) && $request->key!=''){
            $ad_key = $request->key;
        }
        
        $headers = [];
        $url = url('/api/v1/ad_detail');

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
            $headers = [
                'Authorization: Bearer '.$login_token
            ];
        }
        $postFields['item_sef'] = $ad_key;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
       // print_r($response);exit;
        $data = $response_a->data;

        if($data!=null && $data!='') {
            $meta_title = $data->item_name;
            $meta_keywords  = '';
            $meta_description = substr($data->item_description,0,150);

            return view('front.ads.ad_detail', compact('data', 'meta_title', 'meta_keywords', 'meta_description'));
            /*if($data->user_id == session()->get('loginned_user')->id){
                return view('front.ads.ad_detail_owner', compact('data', 'meta_title', 'meta_keywords', 'meta_description'));
            }else{
                return view('front.ads.ad_detail', compact('data', 'meta_title', 'meta_keywords', 'meta_description'));
            } */  
        }else{
            return view('front.ads.ad_detail', compact('data'));
        }
       // return view('front.ads.ad_detail');
        
    }

    /**
     * Show the  pending Bids.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getPendingBid(Request $request){
        $item_id = '';
        if(isset($request->item_id) && $request->item_id!=''){
            $item_id = $request->item_id;
        }
        $headers = [];
        $url = url('/api/v1/pending_bids');

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
            $headers = [
                'Authorization: Bearer '.$login_token
            ];
        }
        $postFields['item_id'] = $item_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
     
        $data = $response_a->data;

        return response()->json([
            'data' => view('front/ads/ajax_pending_bids')->with('data',$data)->render()
        ]);
        
    }

    /**
     * Show the  approved Bids.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getApprovedBid(Request $request){
        $item_id = '';
        if(isset($request->item_id) && $request->item_id!=''){
            $item_id = $request->item_id;
        }
        $headers = [];
        $url = url('/api/v1/approved_bids');

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
            $headers = [
                'Authorization: Bearer '.$login_token
            ];
        }
        $postFields['item_id'] = $item_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
     
        $data = $response_a->data;

        return response()->json([
            'data' => view('front/ads/ajax_approved_bids')->with('data',$data)->render()
        ]);
        
    }


    /**
     * Single image to upload
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    function uploadImage(Request $request){
      
        $url = url('/public/api/v1/upload_image');
        $login_token='';

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Content-Type: multipart/form-data ',
            'Authorization: Bearer '.$login_token
        ];

        $tmpfile = $_FILES['ad_image']['tmp_name'];
        $filename = basename($_FILES['ad_image']['name']);
        $postFields['image']     =  new \CURLFile($tmpfile, $_FILES['ad_image']['type'], $filename);

        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;exit;
    }

    /**
     * Single image to remove
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function removeUploadImage(Request $request){
      
        $url = url('/public/api/v1/delete_temp_image');
        $login_token='';

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Authorization: Bearer '.$login_token
        ];
    
        $postFields['image_id']     =  $request->image_id;
        $postFields['image_key']     =  isset($request->image_key)?$request->image_key:'temp';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        echo 'success';exit;
    }

    /**
     * Show the category drop down in create ad page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxAdCategory(){
      
        $lang_key = 'en';
        $url = url('/public/api/v1/get_category');
        
        if(session()->get('lang_key')){
            $lang_key = session()->get('lang_key');
        }
    
        $headers = [
            'Accept-Language: '.$lang_key,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        //print_r($response);exit;
        $response_a = json_decode($response);
       
        $result_array = @$response_a->data;
        return response()->json([
            'data' => view('front/ads/ajax_ad_category')->with('data',$result_array)->render()
        ]);
    }

    /**
     * Show the all meta data drop down in create ad page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxAdMetaData(){
      
        $lang_key = 'en';
        $url = url('/public/api/v1/get_item_meta_list');
        
        if(session()->get('lang_key')){
            $lang_key = session()->get('lang_key');
        }
    
        $headers = [
            'Accept-Language: '.$lang_key,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        //print_r($response);exit;
        $response_a = json_decode($response);
       
        $result_array = @$response_a->data;
        return response()->json([
            'data' => view('front/ads/ajax_meta_data')->with('data',$result_array)->render()
        ]);
    }

    /**
     * Create Ad
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function createAd(Request $request){
      
        $url = url('/public/api/v1/create_ad');
        $login_token='';

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Authorization: Bearer '.$login_token
        ];
    
        $postFields = $request->all();
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
         echo $response;exit;
      
    }

    /**
     * Like Unlike Ad
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function likeUnlike(Request $request){
      
        $url = url('/public/api/v1/like_unlike');
        $login_token='';

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Authorization: Bearer '.$login_token
        ];
    
        $postFields = $request->all();
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;exit;
      
    }
}
