<?php

namespace App\Http\Controllers\Api\V1;

use App\Facades\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Validator;
use Illuminate\Support\Carbon;
use Hash;
use Log;
use Twilio\Rest\Client;
use Image;
use Auth; 
use File;

use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\LoginLog;
use App\Models\UserDevice;
use App\Models\MessageTemplate;
use App\Models\UserNotification;
use App\Models\ChatMessage;
use App\Models\ItemTempFile;
class AuthController extends Controller
{
    /**
     * Register user and verify number to send OTP
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        
        $rules['name'] =  'required|string|max:191';
        $rules['email'] = 'required|string|email|max:191';
        if(isset($request->phone_number)){
            $rules['phone_number'] = 'required|min:11|max:20|unique:users,user_phone';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $exist_user = User::where('user_email', $request->email)->first();
                if($exist_user){
                    if($exist_user->status=='in_active'){
                   
                        $registered_user        = $exist_user;
    
                    }else{
                        $responseMessage = Lang::get('api.Your email has already exist.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                }else{
            
                   $create_user['user_email']    = $request->email;
                  
                   $create_user['status']   = 'in_active';
                   $create_user['user_otp'] = 9090;
                   if(settingValue('send_same_otp')!='1'){
                       $create_user['user_otp'] = generatePINCode(4);
                   }
                   $create_user['otp_date_time'] =Carbon::now()->toDateTimeString();
                   $create_user['lang_key'] =  'en';
                   
                   $registered_user        = User::create($create_user);
                }
               
                
              
                if ($registered_user) {

                    $find_arr = ['{user_name}', '{user_email}', '{user_phone}', '{otp}'];
                    $rep_arr = [ucfirst($request->name), $request->email, $request->phone_number, $registered_user->user_otp] ;

                    $registered_user->user_phone = $request->phone_number;
                    $registered_user->user_email = $request->email;
                    $registered_user->user_name = $request->name;
                    
                    $this->sendOTPToUser($registered_user, 'send_otp', $find_arr, $rep_arr);
                  
                    if(isset($request->phone_number) && $request->phone_number!=''){
                        $responseMessage = Lang::get('api.User has been registered successfully, an email/message send to your account/phone number.');
                    } else{
                        $responseMessage = Lang::get('api.User has been registered successfully, an email send to your account.');
                    }

                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
                } else {
                    $responseMessage = Lang::get('api.User can not be registered.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
    /**
     * Verify OTP
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function verifyOTP(Request $request)
    {
        $rules['otp'] = 'required';
        $rules['name'] =  'required|string|max:191';
        $rules['email'] = 'required|string|email|max:191';
        //$rules['photo'] = 'required|mimes:jpeg,jpg,png,gif,svg';
        $rules['password'] = 'required|min:8';
        if(isset($request->phone_number)){
            $rules['phone_number'] = 'required|min:11|max:20|unique:users,user_phone';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{

                $exist_user = User::where('user_email', $request->email)->first();
                if($exist_user){
                    if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else{
                        if($exist_user->user_otp == $request->otp){
                            if ($exist_user->otp_date_time != null && $exist_user->otp_date_time != '') {
                                $last_attempt_time = $exist_user->otp_date_time;
                                $current_time = Carbon::now()->toDateTimeString();
                                $otp_validity_for = settingValue('otp_validity')?settingValue('otp_validity'):10;
                                if (Carbon::parse($last_attempt_time)->diffInMinutes(Carbon::parse($current_time)) > $otp_validity_for) {
                                    $responseMessage = Lang::get('api.OTP code has been expired.');
                                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                                }
                            } else {
                                $responseMessage = Lang::get('api.OTP code has been expired.');
                                return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                            }


                             $user['user_phone'] = isset($request->phone_number)?$request->phone_number:null;
                             $user['user_name'] = $request->name;
                             $user['password'] = Hash::make($request->password);
                   
                   
                            if ($request->hasFile('photo')) {

                                $image_tmp = $request->file('photo');

                                if ($image_tmp->isValid()) {
                                    // Upload Images after Resize
                                    $extension = $image_tmp->getClientOriginalExtension();
                                    $fileName = rand(111, 99999) . '.' . $extension;

                                    $user['user_image'] = $fileName;

                                    $large_image_path = public_path('uploads/users/' . $fileName);
                                    Image::make($image_tmp)->save($large_image_path);
                                    $small_image_path = public_path('uploads/users/thumbs/' . $fileName);
                                    Image::make($image_tmp)->resize(50, 50)->save($small_image_path);
                                }
                            }


                            $user['status'] = 'active';
                            $user['user_otp'] = null;
                            $user['otp_date_time'] = null;
                            User::where('id', $exist_user->id)->update($user);
                            
                            $responseMessage = Lang::get('api.Your OTP is verified successfully.');
                            return ApiResponse::successResponse('SUCCESS', $responseMessage, null);

                        } else{
                            $responseMessage = Lang::get('api.Invalid OTP.');
                            return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }
                }
                else{
                    //USER NOT Found
                   
                    $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                   
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
    /**
     * register Verify OTP
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function registerVerifyOtp(Request $request)
    {
      
        $rules['otp'] = 'required';
        $rules['name'] =  'required|string|max:191';
        $rules['email'] = 'required|string|email|max:191';
        //$rules['photo'] = 'required|mimes:jpeg,jpg,png,gif,svg';
        $rules['password'] = 'required|min:8';
        if(isset($request->phone_number)){
            $rules['phone_number'] = 'required|min:11|max:20|unique:users,user_phone';
        }
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{

                $exist_user = User::where('user_email', $request->email)->first();
                if($exist_user){
                    if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else{
                        if($exist_user->user_otp == $request->otp){
                            if ($exist_user->otp_date_time != null && $exist_user->otp_date_time != '') {
                                $last_attempt_time = $exist_user->otp_date_time;
                                $current_time = Carbon::now()->toDateTimeString();
                                $otp_validity_for = settingValue('otp_validity')?settingValue('otp_validity'):10;
                                if (Carbon::parse($last_attempt_time)->diffInMinutes(Carbon::parse($current_time)) > $otp_validity_for) {
                                    $responseMessage = Lang::get('api.OTP code has been expired.');
                                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                                }
                            } else {
                                $responseMessage = Lang::get('api.OTP code has been expired.');
                                return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                            }


                             $user['user_phone'] = isset($request->phone_number)?$request->phone_number:null;
                             $user['user_name'] = $request->name;
                             $user['password'] = Hash::make($request->password);
                   
                   
                            if (isset($request->photo_id) && $request->photo_id!=0 && $request->photo_id!='') {
                                $item_files = ItemTempFile::where('id', $request->photo_id)->first();
                            
                                if($item_files){
                                   
                                    $user['user_image'] = $item_files->file;
                                    $from_path = public_path('uploads/temporary_files/'.$item_files->file);
                                    $to_path = public_path('uploads/users/'.$item_files->file);
                                    $from_thumb_path = public_path('uploads/temporary_files/thumbs/'.$item_files->file);
                                    $to_thumb_path = public_path('uploads/users/thumbs/'.$item_files->file);;
                                    File::move($from_path, $to_path);
                                    File::move($from_thumb_path, $to_thumb_path);
                                    ItemTempFile::where('id', $request->photo_id)->delete();
                                }
                            }


                            $user['status'] = 'active';
                            $user['user_otp'] = null;
                            $user['otp_date_time'] = null;
                            User::where('id', $exist_user->id)->update($user);
                            
                            $responseMessage = Lang::get('api.Your OTP is verified successfully.');
                            return ApiResponse::successResponse('SUCCESS', $responseMessage, null);

                        } else{
                            $responseMessage = Lang::get('api.Invalid OTP.');
                            return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }
                }
                else{
                    //USER NOT Found
                   
                    $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                   
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

    public function sendOTPToUser($registered_user, $key, $find_arr, $rep_arr){
        try{

            $emailTemplate = EmailTemplate::where('email_key', $key)->where('lang_key', 'en')->first();
          
           
            $email_body = $emailTemplate->email_content;
            $email_body = str_replace($find_arr, $rep_arr, $email_body);
        
            $emailData['email_to'] =$registered_user->user_email;
            $emailData['email_message'] = $email_body;
            $emailData['email_subject'] = $emailTemplate->email_subject;
            
            EmailTemplate::sendEmail($emailData);
    
            if($registered_user->user_phone!='' && $registered_user->user_phone!=null){
               Log::info('Phone exists');

                try{
                    $account_sid = getenv("TWILIO_SID");
                    $auth_token = getenv("TWILIO_AUTH_TOKEN");
                    $twilio_number = getenv("TWILIO_NUMBER");
                    $client = new Client($account_sid, $auth_token);
        
                    $phone_number = $registered_user->user_phone;
            
                    $message = MessageTemplate::where('key', $key)->first()->message_template;
                    $message = str_replace('{otp}',$registered_user->user_otp,$message);
                    $message = str_replace('{app_name}',settingValue('app_name'),$message);
                    Log::info($message);
                    $client->messages->create($phone_number,
                        ['from' => $twilio_number, 'body' => $message] );

                    return true;
                    
                }catch(\Exception $e){
                    // $responseMessage = Lang::get('api.Something is going wrong.');
                    Log::info($e->getMessage());
                    $responseMessage = $e->getMessage();
                    return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
                }
            }
        }catch(\Exception $e){
            Log::info($e->getMessage());
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
        }
    }

    /**
     *  Resend Otp User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function resendOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $email_reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
                $phone_reg = "/^[0-9]{4}-[0-9]{7}$/";
                $exist_user = User::where('user_email', trim($request->email_mobile))
                                    ->orWhere('user_phone', trim($request->email_mobile))
                                    ->first();
                if($exist_user){
                   if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else {
                        $user['user_otp'] = 9090;
                        if(settingValue('send_same_otp')!='1'){
                            $user['user_otp'] = generatePINCode(4);
                        }
                        $user['otp_date_time'] =Carbon::now()->toDateTimeString();

                        User::where('id', $exist_user->id)->update($user);
                        $updated_user = User::where('id', $exist_user->id)->first();


                        $find_arr = ['{user_name}', '{user_email}', '{user_phone}', '{otp}'];
                        $rep_arr = [ucfirst($updated_user->user_name), $updated_user->user_email, $updated_user->user_phone, $updated_user->user_otp] ;
    
                        $this->sendOTPToUser($updated_user, 'send_otp', $find_arr, $rep_arr);

                        $responseMessage = Lang::get('api.New OTP is sent to you, please use it here.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);

                    }
                }
                else{
                    if(preg_match($email_reg, $request->email_mobile)) {
                        $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                    }else{
                        $responseMessage = Lang::get('api.This phone number is not registered with us, please proceed to register.');
                    }
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

    
    
    /**
     *  Login
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function Login(Request $request)
    {
        $rules['email_mobile'] =  'required|string|max:191';
        $rules['password'] = 'required|min:8';
       
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $email_reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
                $phone_reg = "/^[0-9]{4}-[0-9]{7}$/";

                $exist_user = User::with('language')
                                    ->where('user_email', $request->email_mobile)
                                    ->orWhere('user_phone', $request->email_mobile)
                                    ->first();

                if($exist_user) {

                    if ($exist_user->status == 'active') {
                        if (Hash::check($request->password, $exist_user->password)) {
                            
                            unset($exist_user->user_otp);
                            unset($exist_user->otp_date_time);
                            unset($exist_user->last_login_ip);
                            unset($exist_user->password);
                            //CREATE ACCESS TOKEN.
                            $exist_user['token'] = $exist_user->createToken('BidTo Token')->accessToken;


                            $total_unread_notifications = UserNotification::with( 'item')
                                                                            ->whereHas('item',function ($q){
                                                                                $q->where('status', 'active');
                                                                            })
                                                                            ->where('is_read', 0)
                                                                            ->where('is_send', 1)
                                                                            ->where('to_id', $exist_user->id)
                                                                            ->count();

                            $total_unread_messages =  ChatMessage::with('item','sender', 'receiver')
                                                                    ->whereHas('item', function($q1){
                                                                        $q1->where('status', 'active');
                                                                    })
                                                                    ->whereHas('sender', function($q2){
                                                                        $q2->where('status', 'active');
                                                                    })
                                                                    ->whereHas('receiver', function($q3){
                                                                        $q3->where('status', 'active');
                                                                    })
                                                                    ->where('is_read', 0)
                                                                    ->where('to_id', $exist_user->id)
                                                                    ->count();
                            $exist_user->total_unread_notification = $total_unread_notifications;
                            $exist_user->total_unread_messages = $total_unread_messages;

                            $responseMessage = Lang::get('api.User has been signed in successfully.');
                            return ApiResponse::successResponse('SUCCESS', $responseMessage, $exist_user);
                        } else {
                            // CODE IS NOT VALID
                            $responseMessage = Lang::get('api.Provided password is not valid.');
                            return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }
                    else if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else{
                        //USER NOT FOUND OR USER NOT ACTIVE
                        if(preg_match($email_reg, $request->email_mobile)) {
                            $responseMessage = Lang::get('api.Email does not exist or you are not active user.');
                        }else{
                            $responseMessage = Lang::get('api.Phone Number does not exist or you are not active user.');
                        }

                        return ApiResponse::errorResponse('BAD_REQUEST',$responseMessage , null);

                    }
                }
                else{
                    //USER NOT FOUND OR USER NOT ACTIVE
                    if(preg_match($email_reg, $request->email_mobile)) {
                        $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                    }else{
                        $responseMessage = Lang::get('api.This phone number is not registered with us, please proceed to register.');
                    }

                    return ApiResponse::errorResponse('BAD_REQUEST',$responseMessage , null);

                }

            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

    /**
     *  SavDeviceToken
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function saveDeviceToken(Request $request)
    {
        $authenticated_user = Auth::user();
        $rules['device_id'] =  'required|string|max:191';
        $rules['device_type'] = 'required';
        $rules['app_mode'] = 'required|in:development,live';
        $rules['device_token'] = 'required';
    
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
           
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            
            try{
                
                $exist_user = User::where('id', $authenticated_user->id)
                                    ->first();
                if($exist_user) {

                   if ($exist_user->status == 'active') {
                        $create_device['device_id'] = $request->device_id;
                        $create_device['device_type'] = $request->device_type;
                        $create_device['app_mode'] = $request->app_mode;
                        $create_device['device_token'] = $request->device_token;
                        $create_device['user_id'] = $exist_user->id;
                        $device = UserDevice::where(function ($q) use ($request) {
                                        $q->where('device_id', $request->device_id)
                                            ->where('device_type', 'like', $request->device_type);
                                        })->orWhere(function ($q) use ($exist_user) {
                                            $q->where('user_id', $exist_user->id);
                                    })->first();
        
                        if ($device) {
                            $device->update($create_device);
                        }
                        else {
                            UserDevice::create($create_device);
                        }
                        $responseMessage = Lang::get('api.Device has been saved successfully.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                   }
                   else if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                   }
                   else{
                    //USER NOT FOUND OR USER NOT ACTIVE
                    $responseMessage = Lang::get('api.Your account is not active yet.');
                    return ApiResponse::errorResponse('BAD_REQUEST',$responseMessage , null);

                   }
                }
                else{
                    //USER NOT FOUND OR USER NOT ACTIVE
                    $responseMessage = Lang::get('api.You are not registered with us, please proceed to register.');
                    return ApiResponse::errorResponse('BAD_REQUEST',$responseMessage , null);

                }
            
            }catch(\Exception $e){
               
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }
    /**
     *  Forgot Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $email_reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
                $phone_reg = "/^[0-9]{4}-[0-9]{7}$/";
                $exist_user = User::where('user_email', trim($request->email_mobile))
                                    ->orWhere('user_phone', trim($request->email_mobile))
                                    ->first();
                if($exist_user){
                    if ($exist_user->status=='in_active') {

                        $responseMessage = Lang::get('api.Email does not exist or you are not active user.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);

                    }
                    else if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else {
                        $user['user_otp'] = 9090;
                        if(settingValue('send_same_otp')!='1'){
                            $user['user_otp'] = generatePINCode(4);
                        }
                        $user['otp_date_time'] =Carbon::now()->toDateTimeString();

                        User::where('id', $exist_user->id)->update($user);
                        $updated_user = User::where('id', $exist_user->id)->first();
                        $find_arr = ['{user_name}', '{user_email}', '{user_phone}', '{otp}'];
                        $rep_arr = [ucfirst($updated_user->user_name), $updated_user->user_email, $updated_user->user_phone, $updated_user->user_otp] ;

                        $this->sendOTPToUser($updated_user, 'forgot_password_send_otp', $find_arr, $rep_arr);
                       

                        $responseMessage = Lang::get('api.New OTP is sent to you, please use it here.');
                        return ApiResponse::successResponse('SUCCESS', $responseMessage, null);

                    }
                }
                else{
                    if(preg_match($email_reg, $request->email_mobile)) {
                        $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                    }else{
                        $responseMessage = Lang::get('api.This phone number is not registered with us, please proceed to register.');
                    }
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }


    /**
     * Verify OTP
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function forgotVerifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'otp' => 'required|size:4',
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $email_reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
                $phone_reg = "/^[0-9]{4}-[0-9]{7}$/";

                $exist_user = User::where('user_email', $request->email_mobile)
                            ->orWhere('user_phone', $request->email_mobile)
                            ->first();

                if($exist_user){
                
                    if($exist_user->status=='in_active'){
                        $responseMessage = Lang::get('api.Sorry, Your account is inactive.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else if($exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else{
                        if($exist_user->user_otp == $request->otp){
                            if ($exist_user->otp_date_time != null && $exist_user->otp_date_time != '') {
                                $last_attempt_time = $exist_user->otp_date_time;
                                $current_time = Carbon::now()->toDateTimeString();
                                $otp_validity_for = settingValue('otp_validity')?settingValue('otp_validity'):10;
                                if (Carbon::parse($last_attempt_time)->diffInMinutes(Carbon::parse($current_time)) > $otp_validity_for) {
                                    $responseMessage = Lang::get('api.OTP code has been expired.');
                                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                                }
                            } else {
                                $responseMessage = Lang::get('api.OTP code has been expired.');
                                return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                            }

                        
                            $user['user_otp'] = 9090;
                            if(settingValue('send_same_otp')!='1'){
                                $user['user_otp'] = generatePINCode(10);
                            }

                            $user['otp_token'] = Hash::make($user['user_otp']);
                            User::where('id', $exist_user->id)->update($user);

                            $responseMessage = Lang::get('api.OTP code has been verified.');
                            return ApiResponse::successResponse('SUCCESS', $responseMessage, $user);

                        } else{
                            $responseMessage = Lang::get('api.Invalid OTP.');
                            return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }
                }
                else{
                    //USER NOT Found
                    if(preg_match($email_reg, $request->email_mobile)) {
                        $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                    }else{
                        $responseMessage = Lang::get('api.This phone number is not registered with us, please proceed to register.');
                    }
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

    /**
     * Reset Password
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_mobile' => 'required',
            'verify_token' => 'required',
            'password'         => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{
            try{
                $email_reg = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";
                $phone_reg = "/^[0-9]{4}-[0-9]{7}$/";

                $exist_user = User::where(function ($query) use($request) {
                                        $query->where('user_email', trim($request->email_mobile))
                                              ->orWhere('user_phone', trim($request->email_mobile));
                                })->first();

                if($exist_user){
            
                    if($exist_user->status=='in_active'){
                        $responseMessage = Lang::get('api.Sorry, Your account is inactive.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else if($exist_user && $exist_user->status=='block'){
                        $responseMessage = Lang::get('api.Your account has been blocked. Please contact to admin.');
                        return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                    }
                    else{
                        $exist_user->otp_token;
                        if($request->verify_token ==  $exist_user->otp_token){
                            
                            $user_array['user_otp'] = null;
                            $user_array['otp_token'] = null;
                            $user_array['otp_date_time'] = null;
                            $user_array['password'] = Hash::make($request->password);
                            User::where('id', $exist_user->id)->update($user_array);
                            $responseMessage = Lang::get('api.Password has been updated.');
                            return ApiResponse::successResponse('SUCCESS', $responseMessage, null);

                        } else{
                            $responseMessage = Lang::get('api.You are requested with invalid token.');
                            return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                        }
                    }
                }
                else{
                    //USER NOT Found
                    if(preg_match($email_reg, $request->email_mobile)) {
                        $responseMessage = Lang::get('api.This email address is not registered with us, please proceed to register.');
                    }else{
                        $responseMessage = Lang::get('api.This phone number is not registered with us, please proceed to register.');
                    }
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            }catch(\Exception $e){
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }
        }
    }

    /**
     * Logout User.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)
    {
        $authenticated_user = Auth::user();

        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string|exists:user_devices',
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        }
        else{

            try{
                //LOGOUT USER
                UserDevice::where('user_id', @$authenticated_user->id)
                            ->where('device_id', $request->device_id)
                            ->delete();

                @Auth::user()->token()->revoke();

                $responseMessage = Lang::get('api.User has been logged out successfully.');
                return ApiResponse::successResponse('SUCCESS', $responseMessage, null);

            }catch(\Exception $e){
                //QUERY EXCEPTION
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

            }

        }

    }
}
