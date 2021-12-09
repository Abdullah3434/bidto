<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use App\Models\LoginLog;
use App\Models\Item;
use App\Models\ChatNotification;
use App\Models\NotificationTemplate;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\IosPushKey;
use App\Helpers\JWT;
use App\Models\UserNotification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

     /**
     * To send Notification in case of chat
     *
     * @param message, type
     * @return \Illuminate\Http\Response
     */
    function sendNotification($message, $key='', $is_deleted=0){
        $user_data = '';
        $sender_name = '';
        $full_image = '';
        $thumb_image ='';


        if($key=='new_message'){
            $message_id = $message->id;
            $chat_id = $message->thread_id;
            $from_id = $message->from_id;
            $to_id = $message->to_id;

            $user_item = Item::where('id',$message->item_id)->first();
            $user_data = User::find($message->from_id);

            if($user_data){

                if($user_data->user_name){
                    $sender_name = ucfirst($user_data->user_name);
                }else if($user_data->user_email){
                    $sender_name = $user_data->user_email;
                }else{
                    $sender_name = $user_data->user_phone;
                }
                $thumb_image = $user_data->thumb_image;
                $full_image = $user_data->full_image;
            }

            $subject = '';
            $message = '';
            $template = NotificationTemplate::where('notification_key', $key )->first();
            if($template){
                $subject = $template->notification_name;
                $message = $template->notification_content;
                $message = str_replace("{user_name}", $sender_name, $message);
            }
            $notification = new ChatNotification();

            $notification->thread_id  = $chat_id;
            $notification->message_id = $message_id;
            $notification->subject = $subject;
            $notification->message = $message;
            $notification->from_id = $from_id;
            $notification->to_id = $to_id;
            $notification->save();

            $notify =  ChatNotification::with('message')->where('id', $notification->id)->first();

            if($to_id>0){
                $notify->sender_name = $sender_name;
                $notify->full_image = $full_image;
                $notify->thumb_image = $thumb_image;
                self::sendDeviceMessageNotification($notify, $is_deleted, $key);
            }
        }else{
            $item_id = @$message->item_id;
            $bid_id = @$message->id;
            if($key=='approve_bid'){
                $to_id = @$message->user_id;
                $from_id = @$message->item->user_id;
            }else{
                $from_id = @$message->user_id;
                $to_id = @$message->item->user_id;
            }
           
            $item_name = @$message->item->item_name;

            $user_data = User::where('id', $from_id)->first();
            
            if($user_data){

                if($user_data->user_name){
                    $sender_name = ucfirst($user_data->user_name);
                }else if($user_data->user_email){
                    $sender_name = $user_data->user_email;
                }else{
                    $sender_name = $user_data->user_phone;
                }

                $thumb_image = $user_data->thumb_image;
                $full_image = $user_data->full_image;
            }

            $template = NotificationTemplate::where('notification_key', $key )->first();

            $subject = '';
            $message = '';
            if($template){
                $subject = $template->notification_name;
                $message = $template->notification_content;
                $message = str_replace("{user_name}", $sender_name, $message);
                $message = str_replace("{item_name}", $item_name, $message);
            }

            $notification = new UserNotification();

            $notification->item_id  = $item_id;
            $notification->bid_id = $bid_id;
            $notification->subject = $subject;
            $notification->message = $message;
            $notification->from_id = $from_id;
            $notification->to_id = $to_id;
            $notification->type = $key;
            $notification->save();

            $notify =  UserNotification::with('item')->where('id', $notification->id)->first();

            if($to_id>0){
                //Log::info($to_id);
                $notify->sender_name = $sender_name;
                $notify->full_image = $full_image;
                $notify->thumb_image = $thumb_image;
                self::sendDeviceOtherNotification($notify, $is_deleted, $key);
            }
        }
    }

    public static function sendDeviceMessageNotification(ChatNotification $notification, $is_deleted, $notification_key) {
    
        $user_id = $notification->to_id;
        $devices = UserDevice::where('user_id', $user_id)->get();

        $title = $notification->subject;

        foreach ($devices as $key => $singleDevice) {

            if ($singleDevice->device_type == 'IOS' || $singleDevice->device_type == 'ios') {

                if($is_deleted==1){
                    $body['aps']['alert'] = array();
                    $body['aps']['content-available']=1;
                    $body['aps']['sound'] = "";
                }else{
                    $body['aps']['alert'] = array('body' => $notification->message, "title" => $title);
                    $body['aps']['sound'] = "default";
                }

                $notification->is_deleted = $is_deleted;
                if($is_deleted==0){
                    $body['obj']['push_type'] = $notification_key;
                }else{
                    $body['obj']['push_type'] = 'delete_message';
                }
               
                $body['obj']['data'] = $notification;
                //Log::info($body);
                $return_res = self::sendIOSNotification($body, $singleDevice, $notification);
                if($return_res==200){
                    ChatNotification::where('id', $notification->id)->update(array('is_sent'=>1));
                }

            } else {

                $res = array();
                $res['notification']['title'] = $title;
                $res['notification']['body'] = $notification->message;
                $notification->is_deleted = $is_deleted;
                if($is_deleted==0){
                    $res['notification']['obj']['push_type']  = $notification_key;
                }else{
                    $res['notification']['obj']['push_type'] = 'delete_message';
                }
                $res['notification']['obj']['data'] = $notification;
                $return_res = self::sendAndroidNotification($res, $singleDevice, $notification);

                if($return_res===FALSE){}
                else{
                    ChatNotification::where('id', $notification->id)->update(array('is_sent'=>1));
                }
            }
        }
    }

    public static function sendDeviceOtherNotification(UserNotification $notification, $is_deleted, $notification_key) {
        $user_id = $notification->to_id;
        $devices = UserDevice::where('user_id', $user_id)->get();

        $title = $notification->subject;

        foreach ($devices as $key => $singleDevice) {

            if ($singleDevice->device_type == 'IOS' || $singleDevice->device_type == 'ios') {

                if($is_deleted==1){
                    $body['aps']['alert'] = array();
                    $body['aps']['content-available']=1;
                    $body['aps']['sound'] = "";
                }else{
                    $body['aps']['alert'] = array('body' => $notification->message, "title" => $title);
                    $body['aps']['sound'] = "default";
                }

                $notification->is_deleted = $is_deleted;
                if($is_deleted==0){
                    $body['obj']['push_type'] = $notification_key;
                }else{
                    $body['obj']['push_type'] = 'delete_notification';
                }
                $body['obj']['data'] = $notification;
               // Log::info($body);
                $return_res = self::sendIOSNotification($body, $singleDevice, $notification);
                if($return_res==200){
                    UserNotification::where('id', $notification->id)->update(array('is_send'=>1));
                }

            } else {

                $res = array();
                $res['notification']['title'] = $title;
                $res['notification']['body'] = $notification->message;
                $notification->is_deleted = $is_deleted;
                if($is_deleted==0){
                    $res['notification']['obj']['push_type']  = $notification_key;
                }else{
                    $res['notification']['obj']['push_type'] = 'delete_notification';
                }
                $res['notification']['obj']['data'] = $notification;
                $return_res = self::sendAndroidNotification($res, $singleDevice, $notification);

                if($return_res===FALSE){}
                else{
                    UserNotification::where('id', $notification->id)->update(array('is_send'=>1));
                }
            }
        }
    }

    public static function getAPNSToken(){
        $single = IosPushKey::first();
        $token = "";

        if($single && (strtotime($single->expired_at) > time())){
            $token = $single->token;
        }else{

            IosPushKey::truncate();

            $endTime = strtotime("+20 minutes", time());

            $authKey = public_path().'/ios_certificates/push_key.p8';
            $arParam['teamId'] = 'J7R6Z6TQ65';
            $arParam['authKeyId'] = 'P3A88FDL7T';

            $arClaim = ['iss'=>$arParam['teamId'], 'iat'=>time()];

            $arParam['p_key'] = file_get_contents($authKey);

            $create_key['token'] = JWT::encode($arClaim, $arParam['p_key'], $arParam['authKeyId'], 'RS256');
            $create_key['expired_at'] = date('Y-m-d H:i:s' , $endTime);

            IosPushKey::create($create_key);

            $token = $create_key['token'];
        }

        return $token;

    }

    public static function sendIOSNotification($body, $device, $notification)
    {

        $header_token = self::getAPNSToken();

        $noti['header_jwt'] = $header_token;
        $noti['apns-topic'] = "com.elementarylogics.bidToDev";

        $device_token = $device->device_token;

        $sendDataJson = json_encode($body);

        $endPoint = 'https://api.development.push.apple.com/3/device';
        if($device->app_mode == 'live') {
            $endPoint = 'https://api.push.apple.com/3/device';
        }

        $ar_request_head[] = sprintf("content-type: application/json");
        $ar_request_head[] = sprintf("authorization: bearer %s", $noti['header_jwt']);
        $ar_request_head[] = sprintf("apns-topic: %s", $noti['apns-topic']);


        $url = sprintf("%s/%s", $endPoint, $device_token);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $sendDataJson);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ar_request_head);

        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            Log::info('Error:' . curl_error($ch));
        }
        curl_close($ch);
        Log::info('Ios Result is '.$result);
        Log::info('Ios HttpCode is '.$httpcode);
        return $httpcode;

    }

    public static function sendAndroidNotification($body, $device, ChatNotification $notification) {
        $apiKey = "AAAAE-uKy2c:APA91bGAHmhUr70o-viHI6dneRlGVTedmHci9_daChS1_JBa8W1Wq13NIEXEQbbMmV4hrdzlgCcJlWRByRYgGseluKD1bp1ibf9cJAsftp6cnkQ-XBNZ1rE09KuCDJdjPHCIesttPFmd";
        $device_token = $device->device_token;

        $data = array(
            'to' => $device_token,
            'data' => $body,
        );

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json',
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);

        return $result;

    }
    
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $total = count($items);

        $perPage = $perPage ?   $perPage    :   15;
        $currentPage = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = array_slice($items, ($currentPage - 1) * $perPage, $perPage);

        $paginator = new LengthAwarePaginator($items, $total, $perPage, $currentPage);
        return $paginator;
    }
     /**
     * To validate number
     *
     * @param  Phone_number
     * @return \Illuminate\Http\Response
     */
    public function validNumber($phone_number=''){

        $phone_number =  preg_replace('~\D~', '', $phone_number);
        if(substr($phone_number,0,1) == 0){
            $phone_number =  substr_replace($phone_number,'',0,1);

        }
        return $phone_number;
    }
     /**
     * To check maximum attempts of login
     *
     * @param  user_id, client_ip, type, user_type
     * @return \Illuminate\Http\Response
     */

    function checkMaximumAttempts($user_id,$clientIp, $type)
    {
        $attempts = LoginLog::where('user_id', $user_id)
            ->where('type', $type)
            ->count();

        $last_attempt = LoginLog::where('user_id', $user_id)
            ->where('type', $type)
            ->orderby('id', 'desc')
            ->first();

        if ($last_attempt) {
            $last_attempt_time = $last_attempt->created_at;
            $current_time = Carbon::now()->toDateTimeString();

            if (Carbon::parse($last_attempt_time)->diffInMinutes(Carbon::parse($current_time)) <= settingValue('clear_attempts')) {
                if($type == 'send_otp'){
                    $login_attempts = settingValue('send_otp_attempts') ? settingValue('send_otp_attempts') : 5;
                }else{
                    $login_attempts = settingValue('verify_otp_attempts') ? settingValue('verify_otp_attempts') : 5;
                }

                $patient_block_for = settingValue('block_for') ? settingValue('block_for') : 5;

                if ($attempts >= $login_attempts) {
                    if (Carbon::parse($last_attempt_time)->diffInMinutes(Carbon::parse($current_time)) <= settingValue('block_for')) {
                        $remaining_minutes = ((int)$patient_block_for - (int)Carbon::parse($last_attempt_time)->diffInMinutes(Carbon::parse($current_time)));

                        if ($remaining_minutes <= 0) {
                            //$remaining_minutes =1;
                            LoginLog::where('user_id', $user_id)
                                ->where('type', $type)
                                ->delete();
                        }else{
                            session(['last_attempt_time' => strtotime(Carbon::now()->addMinutes($remaining_minutes))]);
                        }

                        return $remaining_minutes;
                    } else {
                        LoginLog::where('user_id', $user_id)
                            ->where('type', $type)
                            ->delete();
                        return 0;
                    }
                } else {
                    return 0;
                }
            } else {
                LoginLog::where('user_id', $user_id)
                    ->where('type', $type)
                    ->delete();
                return 0;
            }
        } else {
            return 0;
        }
    }
    /**
     * Insert data in login log table to check maximum attempts of login
     *
     * @param  user_id, ip, type
     * @return \Illuminate\Http\Response
     */
    function addLoginLogs($user_id, $ip, $type){
        $loginLogs['user_id'] = $user_id;
        $loginLogs['ip'] = $ip;
        $loginLogs['type'] = $type;
        $loginLogs['created_at'] =  Carbon::now()->toDateTimeString();
        $loginLogs['updated_at'] =  Carbon::now()->toDateTimeString();
        LoginLog::create($loginLogs);
        return true;
    }
}
