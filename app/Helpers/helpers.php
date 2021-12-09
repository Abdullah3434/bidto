<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Setting;

if(!function_exists('getBannedWords')){
    function getBannedWords(){
        $banned_words  = settingValue('banned_words');
        return $banned_words;
    }
}
if (! function_exists('encodeURIComponent')) {
    function encodeURIComponent($str)
    {
        $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
        return strtr(rawurlencode($str), $revert);
    }
}

if (! function_exists('isActiveRoute')) {

    function isActiveRoute($route, $output = "active")
    {
        if (Route::current()->uri == $route) return $output;
    }
}

if (! function_exists('setActive')) {

    function setActive($paths)
    {
        foreach ($paths as $path) {

            if(Request::is($path . '*'))
                return ' class=active';
        }

    }
}

if (! function_exists('setFrontActive')) {

    function setFrontActive($paths)
    {
        foreach ($paths as $path) {

            if(Request::is($path . '*'))
                return ' active';
        }

    }
}

if (!function_exists('isFrontActiveRoute')) {

    function isFrontActiveRoute($route, $output = "active") {
      
        if (Route::current()->uri == $route) {

            return true;
        }
        return false;

    }
}

if (! function_exists('checkImage')) {

    function checkImage($path)
    {
        if (\File::exists(public_path('uploads/'.$path))){
           return asset('public/uploads/'.$path);
        }else{
            $place_holder = 'no_user_image.png';
            $path= substr($path, strrpos($path, '/') + 1);
            if($path!=''){
                $place_holder = $path;
            }
            return asset('public/uploads/'.$place_holder);
        }
    }
}


function custom_image_resize($src, $dst, $width, $height, $crop = 0)
{
   ini_set('memory_limit', '64M');
   if (!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";
   $type = strtolower(substr(strrchr($src, ".") , 1));
   if ($type == 'jpeg') $type = 'jpg';
   switch ($type) {
   case 'bmp':
       $img = imagecreatefromwbmp($src);
       break;

   case 'gif':
       $img = imagecreatefromgif($src);
       break;

   case 'jpg':
       $img = imagecreatefromjpeg($src);
       break;

   case 'png':
       $img = imagecreatefrompng($src);
       break;

   default:
       return "Unsupported picture type!";
   }

   // resize

   if ($crop) {
       if ($w < $width or $h < $height) return "Picture is too small!";
       $ratio = max($width / $w, $height / $h);
       $h = $height / $ratio;
       $x = ($w - $width / $ratio) / 2;
       $w = $width / $ratio;
   }
   else {
       if ($w < $width and $h < $height) return "Picture is too small!";
       $ratio = min($width / $w, $height / $h);
       $width = $w * $ratio;
       $height = $h * $ratio;
       $x = 0;
   }

   $new = imagecreatetruecolor($width, $height);

   // preserve transparency

   if ($type == "gif" or $type == "png") {
       imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
       imagealphablending($new, false);
       imagesavealpha($new, true);
   }

   imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);
   switch ($type) {
   case 'bmp':
       imagewbmp($new, $dst);
       break;

   case 'gif':
       imagegif($new, $dst);
       break;

   case 'jpg':
       imagejpeg($new, $dst);
       break;

   case 'png':
       imagepng($new, $dst);
       break;
   }

   return true;
}




if (! function_exists('set_date_formate')) {

    function set_date_formate($date)
    {
        return date('d-m-Y',strtotime($date));
    }
}

if (! function_exists('set_time_formate')) {

    function set_time_formate($time)
    {
        return date('h:i A',strtotime($time));
    }
}


if (! function_exists('set_24_time_formate')) {

    function set_24_time_formate($time)
    {
        return date('H:i',strtotime($time));
    }
}

function get_tooltip($text='')
{
  return 'data-placement="top" data-toggle="tooltip" class="tooltips mr-20" type="button" data-original-title="'.$text.'"';
}

if (! function_exists('settingValue')) {

    function settingValue($key)
    {
        $setting = Setting::where('key',$key)->first();
        if($setting)
            return $setting->value;
        else
            return '';
    }
}
if(!function_exists('returnresponse')){
    function returnresponse($status, $msg, $data=[], $code)
    {
        $response = [
            'status'    => $status,
            'message'   => $msg,
            'data'      => (object) $data
        ];
        return response($response, $code);
    }
}

if (! function_exists('generatePINCode')) {

    function generatePINCode($digits) {
        return random_int(pow(10, $digits-1), pow(10, $digits)-1);
    }

}
if (! function_exists('check_cc')) {
    function check_cc($cc){

        $regs = array(
            "master_card" => "/^(?:5[1-5]|222[1-9]|22[3-9][0-9]|2[3-6][0-9][0-9]|27[0-1][0-9]|2720)\d+$/",
            "visa" => "/^4[0-9]\d+$/",
            "diners" => "/^(?:5[45]|36|30[0-5]|3095|3[8-9])\d+$/",
            "jcb" => "/^(?:35[2-8][0-9])\d+$/",
            "american" => "/^(34|37)\d+$/",
            "discover" => "/^6(?:011|22(12[6-9]|1[3-9][0-9]|[2-8][0-9][0-9]|9[01][0-9]|92[0-5])|5|4|2[4-6][0-9]{3}|28[2-8][0-9]{2})\d+$/"
        );
        

        foreach ($regs as $brand => $single_reg) {
            if (preg_match($single_reg, $cc)) {
                return $brand;
            }
        }
        return 'unknown';
       
    }
}