<?php

namespace App\Http\Controllers\Front\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App;
use Illuminate\Support\Carbon;
class GeneralController extends Controller
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
     * Show the underdevelopment page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function underDevelopment(){
        return view('front.under_development');
    }

    /**
     * Show the category page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryView(){
        return view('front.category.category');
    }

    /**
     * Show the category list for category page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxCategory(Request $request){
      
        $lang_key = 'en';
        $url = url('/public/api/v1/get_category');
        
        if(session()->get('lang_key')){
            $lang_key = session()->get('lang_key');
        }
    
        $headers = [
            'Accept-Language: '.$lang_key,
        ];

        $page = $request->page_no;
        
        $url.='?os=web&page='.$page;
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
      
        $response_a = json_decode($response);
       
        $result_array = @$response_a->data;
        
        return response()->json([
            'data' => view('front/category/ajax_category')->with('data',$result_array)->render()
        ]);
    }
    /**
     * Show the language list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxLanguage(){
      
        $lang_key = 'en';
        $url = url('/public/api/v1/get_langauge');
        
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
            'data' => view('front/general/ajax_language')->with('data',$result_array)->render()
        ]);
    }

    /**
     * update the language list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function changeLanguage(Request $request){

        $postFields['language'] =  @session()->get('lang_key');
        $login_token='';

        $url = url('/public/api/v1/change_language');
        

        if(isset($request->language)){
            $postFields['language'] =$request->language;
        }
    
        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Authorization: Bearer '.$login_token
        ];
      

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

       
        $response_a = json_decode($response);
        if($response_a->status==true){
            session(['lang_key' =>  $postFields['language']]);
            App::setLocale($postFields['language']);
        }
       
        
        echo 'success';
    }

     /**
     * Show the category list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxHomeCategory(){
      
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
            'data' => view('front/general/ajax_home_category')->with('data',$result_array)->render()
        ]);
    }

       /**
     * Show the settings list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAjaxSettings(){
      
        $login_token='';
        $url = url('/public/api/v1/get_settings');
        
        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
        }
        $headers = [
            'Authorization: Bearer '.$login_token
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
        
        $response_a = json_decode($response);
       
        $result_array = @$response_a->data;


        $result_array->listing_end_date = Carbon::now()->addDays($result_array->ad_days)->format('d M, Y');
        $result_array->promotion_end_date = Carbon::now()->addDays($result_array->promotion_days)->format('d M, Y');;

        return response()->json($result_array);
    }
}
