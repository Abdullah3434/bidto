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

use App\Models\Category;
use App\Models\PageContent;
use App\Models\Sponsor;
use App\Models\Language;
use App\Models\EmailTemplate;

use App\Models\ItemColor;
use App\Models\User;
use App\Models\ItemCylinder;
use App\Models\ItemTransmission;
use App\Models\ItemMake;
use App\Models\ItemCondition;
use App\Models\ItemType;

class GeneralController extends Controller
{
     /**
     * POST Contact Us
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function contactUs(Request $request)
    {

        $authenticated_user  = Auth::user();
        
        $validator           = Validator::make($request->all(), [
            'title' => 'required|max:191',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        } 
        else {

            try {

                    //SEND EMAIL TO ADMIN
                    $email_content = EmailTemplate::where('email_key', 'contact_us')->where('lang_key', 'en')->first();
                   
                    $email_body = $email_content->email_content;

                    $email_body = str_replace('{name}',$authenticated_user->user_name,$email_body);
                    $email_body = str_replace('{email}', $authenticated_user->user_email, $email_body);
                    $email_body = str_replace('{phone_number}', $authenticated_user->user_phone, $email_body);
                    $email_body = str_replace('{title}', $request->title, $email_body);
                    $email_body = str_replace('{description}',trim($request->description),$email_body);

                    $email['from_email'] = $authenticated_user->user_email;
                    $email['email_to'] = settingValue('support_email');
                    
                    $email['email_subject'] = $email_content->email_subject;
                    $email['email_message'] = $email_body;
                    EmailTemplate::sendEmail($email);

                    $responseMessage = Lang::get("api.An Email has been sent to administration. They will contact to you as soon as possible.");
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, null);
            } catch (\Exception $e) {
                // $responseMessage = Lang::get('api.Something is going wrong.');
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }
   /**
     * get Category List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getCategoryList(Request $request)
    {
        try{
           
            $lang_key = 'en';
            $categories = Category::where('status', 'active');
            if($request->header('Accept-Language')!=''){
               
                $lang_key =$request->header('Accept-Language');
            }
            
            $categories = $categories->where('lang_key', $lang_key)->orderby('cat_name', 'asc')->get();

            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $categories);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

     /**
     * get Language List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getLanguageList(Request $request)
    {
        try{
          
            $langauges = Language::where('status', 'active');
            
           /* if($request->header('Accept-Language')!=''){
                $langauges->where('language_key', $request->header('Accept-Language'));
            }else{
                $langauges->where('language_key', 'en');
            }*/
            
            $langauges = $langauges->orderby('id', 'asc')->get();
            
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $langauges);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * get Sponsors List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getSponsorList(Request $request)
    {
        try{

            $sponsors = Sponsor::where('status', 'active')->orderby('id', 'asc')->get();
            
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $sponsors);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

     /**
     * Get Content Page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function contentPage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'key' => 'required|max:255',
        ]);
        if ($validator->fails()) {

            $responseMessage = $validator->errors()->first();
            return ApiResponse::errorResponse('VALIDATION_ERROR', $responseMessage, null);
        } else {

            try {
                //GET CONTENT PAGE ACCORDING TO REQUESTED PAGE KEY
                $content_page = PageContent::where('page_key', $request->key);
                if($request->header('Accept-Language')!=''){
                    $content_page->where('lang_key', $request->header('Accept-Language'));
                }else{
                    $content_page->where('lang_key', 'en');
                }
                /*if(isset($request->lang_key) && $request->lang_key!=''){
                    $content_page->where('lang_key', $request->lang_key);
                }else{
                    $content_page->where('lang_key', 'en');
                }*/
                $content_page = $content_page->first();

                if ($content_page) {

                    $responseMessage = Lang::get('api.Records have been found.');
                    return ApiResponse::successResponse('SUCCESS', $responseMessage, $content_page);
                } else {

                    $responseMessage = Lang::get('api.No record found.');
                    return ApiResponse::errorResponse('BAD_REQUEST', $responseMessage, null);
                }
            } catch (\Exception $e) {
                //QUERY EXCEPTION
                $responseMessage = $e->getMessage();
                return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);
            }
        }
    }

    /**
     * get Condition, make, model, transmission, cylinder, color, types List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function getItemMetaDataList(Request $request)
    {
        try{
            $data['item_conditions'] = ItemCondition::orderby('condition_name', 'asc')->get();
            $data['item_makes'] = ItemMake::with('models')->orderby('make_name', 'asc')->get();
            $data['item_transmission'] = ItemTransmission::orderby('transmission_name', 'asc')->get();
            $data['item_cylinders'] = ItemCylinder::orderby('item_cylinder', 'asc')->get();
            $data['item_colors'] = ItemColor::orderby('color_name', 'asc')->get();

            $lang_key = 'en';
            if($request->header('Accept-Language')!=''){
               
                $lang_key =$request->header('Accept-Language');
            }

            $data['item_types'] = ItemType::where('lang_key', $lang_key)->orderby('type_name', 'asc')->get();

            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $data);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    
    /**
     * get Condition List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function getConditionList(Request $request)
    {
        try{
            $item_conditions = ItemCondition::orderby('condition_name', 'asc')->get();
        
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $item_conditions);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * get Make List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function getMakeList(Request $request)
    {
        try{
            $item_makes = ItemMake::with('models')->orderby('make_name', 'asc')->get();
        
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $item_makes);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * get Transmission List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   
    public function getTransmissionList(Request $request)
    {
        try{
            $item_transmission = ItemTransmission::orderby('transmission_name', 'asc')->get();
        
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $item_transmission);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * get Cylinders List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCylinderList(Request $request)
    {
        try{
            $item_cylinders = ItemCylinder::orderby('item_cylinder', 'asc')->get();
        
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $item_cylinders);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * get Colors List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getColorList(Request $request)
    {
        try{
            $item_colors = ItemColor::orderby('id', 'asc')->get();
        
            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $item_colors);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }

    /**
     * get Settings List
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getSettingsDataList(Request $request)
    {
        try{
           
            $data['support_email'] = settingValue('support_email') ;
            $data['facebook'] = settingValue('facebook');
            $data['twitter'] = settingValue('twitter');
            $data['google'] = settingValue('google');
            $data['ad_cost'] = settingValue('ad_cost');
            $data['ad_days'] = settingValue('ad_days');
            $data['promoted_ad_cost'] = settingValue('promoted_ad_cost');
            $data['promotion_days'] = settingValue('promotion_days');
            $data['promotion_label'] = settingValue('promotion_label');
            $remaining_ads = 0;
            $remaining_balance = 0;
            if(@Auth::guard('api')->user()){
                $user = User::where('id', Auth::guard('api')->user()->id)->first();
                if($user){
                    $remaining_ads = $user->promotion_ads;
                    $remaining_balance = $user->user_balance;
                }
            }
            $data['remaining_ads'] = $remaining_ads;
            $data['remaining_balance'] = number_format($remaining_balance,2);

            $data['min_price_filter'] = settingValue('min_price_filter');
            $data['max_price_filter'] = settingValue('max_price_filter');

            $responseMessage = Lang::get('api.Records have been found.');
            return ApiResponse::successResponse('SUCCESS', $responseMessage, $data);

        }catch(\Exception $e){

            //QUERY EXCEPTION
            // $responseMessage = Lang::get('api.Something is going wrong.');
            $responseMessage = $e->getMessage();
            return ApiResponse::errorResponse('SERVER_ERROR', $responseMessage, null);

        }
    }
}
