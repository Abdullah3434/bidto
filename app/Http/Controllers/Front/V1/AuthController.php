<?php

namespace App\Http\Controllers\Front\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

     /**
     * Show the application register view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function registerView()
    {

        return view('front.auth.register');
    }

     /**
     * User register method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function register(Request $request){

        $loginData = $request->all();

        $url = url('/public/api/v1/register');

        $postFields['name'] = $loginData['name'];
        $postFields['email']     = $loginData['email'];
    
       
        $postFields['password']     = $loginData['password'];
        if(isset($loginData['phone_number']) && $loginData['phone_number']!='' && $loginData['phone_number']!=null){
            $postFields['phone_number']     = $loginData['phone_number'];
        }


        $headers = [
            'Content-Type: multipart/form-data '
        ];
        
        if(isset($loginData['photo']) && $loginData['photo']!='' && $loginData['photo']!=null){

            $tmpfile = $_FILES['photo']['tmp_name'];
            $filename = basename($_FILES['photo']['name']);
            $input['image']     =  new \CURLFile($tmpfile, $_FILES['photo']['type'], $filename);
            $input['type']     = 'user';

            $upload_image_url = url('/public/api/v1/upload_image');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $upload_image_url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $response = curl_exec($ch);
            curl_close($ch);
            $response_a = json_decode($response);
            if($response_a->status == true){
                    $postFields['photo_id'] = @$response_a->data->id;
            }
        }
    
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

        if($response_a->status == true){

            Session::flash('success_message', @$response_a->message);
            return redirect('/code-verification?email='.base64_encode($postFields['email']))->withInput($postFields);

        }else{

            Session::flash('error_message', $response_a->message );
            return redirect('/register')->withInput();
        }
    }

    
     /**
     * Show the application register code verification view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function codeVerificationView(Request $request)
    {

        $dataFields =  $request->all();
        $email_mobile = base64_decode($dataFields['email']);
        return view('front.auth.verify_otp', compact('email_mobile'));
    }

    
     /**
     * User register code verification method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function codeVerification(Request $request){

       
        $loginData = $request->all();

        $url = url('/public/api/v1/register_verify_otp');

        $postFields['email'] = $loginData['email'];
        $postFields['otp']     = $loginData['otp'];
        $postFields['name'] = $loginData['name'];
        
        $postFields['password']     = $loginData['password'];
        if(isset($loginData['phone_number']) && $loginData['phone_number']!='' && $loginData['phone_number']!=null){
            $postFields['phone_number']     = $loginData['phone_number'];
        }

        if(isset($loginData['photo_id']) && $loginData['photo_id']!='' && $loginData['photo_id']!=null){
 
            $postFields['photo_id']     =  $loginData['photo_id'];
        }


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $response_a = json_decode($response);

       
        if($response_a->status == true){

            Session::flash('success_message', @$response_a->message);
            return redirect('/success-verification');

        }else{

            Session::flash('error_message', $response_a->message );
            return redirect('/code-verification?email='.base64_encode($postFields['email']))->withInput();
        }
    }

    /**
     * Show the application success code verification view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function successVerificationView(Request $request)
    {
        return view('front.auth.success_verify_registeration');
    }

       /**
     * User register method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function resendOtp(Request $request){

        $loginData = $request->all();


        $url = url('/public/api/v1/resend_otp');

        $postFields['email_mobile'] = $loginData['dataObject']['email_mobile'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response);

        return json_encode($response_a);

    }
    /**
     * Show the application email login view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emailLoginView()
    {
        return view('front.auth.email_login');
    }

    /**
     * Show the application phone login view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function phoneLoginView()
    {
        return view('front.auth.phone_login');
    }

    /**
     * User Login method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login(Request $request){

        $email_reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";

        $loginData = $request->all();

        $url = url('/public/api/v1/login');

        $postFields['email_mobile'] = $loginData['email_mobile'];
        $postFields['password']     = $loginData['password'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response);
        
        session(['currency' =>'$']);
        session(['lang_key' =>  'en']);

        session(['min_price_filter' =>  0]);
        session(['max_price_filter' =>  100000]);

        if($response_a->status == true){
            
            session(['loginned_user' =>  $response_a->data]);
            session(['login_token' =>  $response_a->data->token]);
            session(['lang_key' =>  $response_a->data->lang_key]);
            session(['currency' =>  @$response_a->data->language->currency_symbol]);
            session(['total_unread_notifications' =>  @$response_a->data->total_unread_notification]);
            session(['total_unread_messages' =>  @$response_a->data->total_unread_messages]);


            $url = url('/public/api/v1/get_settings');
            $headers = [
                'Authorization: Bearer '.$response_a->data->token
            ];
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $responses = curl_exec($ch);
            curl_close($ch);
    
            $responses_a = json_decode($responses);
            if($responses_a->status == true){
                session(['min_price_filter' =>  $responses_a->data->min_price_filter]);
                session(['max_price_filter' =>  $responses_a->data->max_price_filter]);
            }
            return redirect('/');
        }else{
            
            Session::flash('error_message', $response_a->message );

            if(preg_match($email_reg, $request->email_mobile)) {
                return redirect('/login')->withInput();
            }else{
                return redirect('/phone-login')->withInput();
            }
           
        }
    }
    /**
     * Show the application email forgot password view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function emailForgotPasswordView(Request $request)
    {
        if(isset($request->phone) && $request->phone==1){

            $phone = 1;
            return view('front.auth.email_forgot_password',compact('phone'));
        }else{
            return view('front.auth.email_forgot_password');
        }
       
    }

    /**
     * User forgot password method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forgotPassword(Request $request){

        $loginData = $request->all();

        $url = url('/public/api/v1/forgot_password');
        $phone=0;

        if($request->type=='email'){
            $postFields['email_mobile'] = $loginData['email'];
        }else if($request->type=='combine'){
            $postFields['email_mobile'] = $loginData['email_mobile'];
        }else{
            $phone=1;
            $postFields['email_mobile'] = $loginData['phone'];
        }
        
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response);

        if($request->type=='combine'){
            return json_encode($response_a);
        }else{
            if($response_a->status == true){

                Session::flash('success_message', @$response_a->message);
                return redirect('/reset-verification?phone='.$phone.'&emailmobile='.base64_encode($postFields['email_mobile']));
    
            }else{
    
                Session::flash('error_message', $response_a->message );
                return redirect('/forgot-password?phone='.$phone)->withInput();
            }
        }
    }

    /**
     * Show the application register code verification view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function resetVerificationView(Request $request)
    {
        $dataFields =  $request->all();
        $email_mobile = base64_decode($dataFields['emailmobile']);
        $phone = 0;
        if(isset($request->phone)){
            $phone = $request->phone;
        }
        return view('front.auth.reset_verify_otp', compact('email_mobile', 'phone'));
    }

    
     /**
     * User register code verification method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function resetVerification(Request $request){

        $loginData = $request->all();

        $url = url('/public/api/v1/forgot_verify_otp');

        $postFields['email_mobile'] = $loginData['email_mobile'];
        $postFields['otp']     = $loginData['otp'];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response);

        $phone = 0;
        if(isset($request->phone)){
            $phone = $request->phone;
        }

        if($response_a->status == true){

            Session::flash('success_message', @$response_a->message);
            return redirect('/reset-password?phone='.$phone.'&emailmobile='.base64_encode($postFields['email_mobile']).'&token='.@$response_a->data->otp_token);

        }else{

            Session::flash('error_message', $response_a->message );
            return redirect('/reset-verification?phone='.$phone.'&emailmobile='.base64_encode($postFields['email_mobile']))->withInput();
        }
    }

    /**
     * Show the application email forgot password view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function resetPasswordView(Request $request)
    {
        $dataFields   =  $request->all();
        $email_mobile =  base64_decode($dataFields['emailmobile']);
        $otp_token    =  $dataFields['token'];
        $phone = 0;
        if(isset($request->phone)){
            $phone = $request->phone;
        }
        return view('front.auth.reset_password', compact('email_mobile','otp_token', 'phone'));
    }

    /**
     * User forgot password method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function resetPassword(Request $request){

        $loginData = $request->all();

        $url = url('/public/api/v1/reset_password');

        $postFields['email_mobile'] = $loginData['email_mobile'];
        $postFields['verify_token'] = $loginData['verify_token'];
        $postFields['password'] = $loginData['password'];
        $postFields['confirm_password'] = $loginData['confirm_password'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response_a = json_decode($response);

        $phone = 0;
        if(isset($request->phone)){
            $phone = $request->phone;
        }
        if($response_a->status == true){
            Session::flash('success_message', @$response_a->message);
            return redirect('/reset-success');

        }else{

            Session::flash('error_message', $response_a->message );
            return redirect('/reset-password?phone='.$is_phone.'&emailmobile='.base64_encode($postFields['email_mobile']).'&token='.$postFields['verify_token'])->withInput();
        }
    }
    /**
     * Show the application success code verification view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function resetSuccessView(Request $request)
    {
        return view('front.auth.reset_password_success');
    }

     /**
     * LOgout 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function logout()
    {
        session()->forget('loginned_user');
        session()->forget('login_token');
        session()->forget('total_unread_notifications');
        session()->forget('total_unread_messages');
        return redirect('/login');
    }
}
