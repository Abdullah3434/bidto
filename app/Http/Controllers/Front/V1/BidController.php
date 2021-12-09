<?php

namespace App\Http\Controllers\Front\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
class BidController extends Controller
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
     * Add new bId.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function addBid(Request $request){
        if(isset($request->item_id) && $request->item_id!=''){
            $postFields['item_id'] = $request->item_id;
        }
        if(isset($request->amount) && $request->amount!=''){
            $postFields['amount'] = $request->amount;
        }
        $headers = [];
        $url = url('/api/v1/add_bid');

        if(session()->get('login_token')){
            $login_token = session()->get('login_token');
            $headers = [
                'Authorization: Bearer '.$login_token
            ];
        }
        
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
     
       if($response_a->status==true){
            Session::flash('success_message', @$response_a->message);
       }else{
            Session::flash('error_message', $response_a->message );
       }
        echo 'success';exit;
    }


}
