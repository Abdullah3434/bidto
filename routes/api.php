<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => ['issiteavailable']], function(){
    

    Route::post('register', 'Api\V1\AuthController@register');
    //for web
    Route::post('register_verify_otp', 'Api\V1\AuthController@registerVerifyOtp');
    //for app
    Route::post('verify_otp', 'Api\V1\AuthController@verifyOTP');


    Route::post('resend_otp', 'Api\V1\AuthController@resendOtp');
    Route::post('login', 'Api\V1\AuthController@login');
    Route::post('forgot_password', 'Api\V1\AuthController@forgotPassword');
    Route::post('forgot_verify_otp', 'Api\V1\AuthController@forgotVerifyOTP');
    Route::post('reset_password', 'Api\V1\AuthController@resetPassword');
    
    //General
    Route::get('get_category', 'Api\V1\GeneralController@getCategoryList');
    Route::get('get_sponsor', 'Api\V1\GeneralController@getSponsorList');
    Route::post('page', 'Api\V1\GeneralController@contentPage');
    Route::get('get_langauge', 'Api\V1\GeneralController@getLanguageList');
    Route::get('get_item_meta_list', 'Api\V1\GeneralController@getItemMetaDataList');
    Route::get('get_settings', 'Api\V1\GeneralController@getSettingsDataList');
   // Route::get('get_condition', 'Api\V1\GeneralController@getConditionList');
    //Route::get('get_makes', 'Api\V1\GeneralController@getMakeList');
    //Route::get('get_transmission', 'Api\V1\GeneralController@getTransmissionList');
    //Route::get('get_cylinder', 'Api\V1\GeneralController@getCylinderList');
    //Route::get('get_color', 'Api\V1\GeneralController@getColorList');
    Route::post('upload_image', 'Api\V1\AdController@uploadImage');
    Route::group(['middleware' => 'auth:api'], function () {
            //User
            Route::post('/save_device_token', 'Api\V1\AuthController@saveDeviceToken');
            //Chat
            Route::get('/get_thread', 'Api\V1\ChatMessageController@getThread');
            Route::post('/get_messages', 'Api\V1\ChatMessageController@getMessages');
            Route::post('/delete_message', 'Api\V1\ChatMessageController@deleteMessage');
            Route::post('/send_message', 'Api\V1\ChatMessageController@sendChatMessage');
            Route::post('/get_thread_id', 'Api\V1\ChatMessageController@getThreadId');

            //Ads
            //Route::get('purchase_promotion', 'Api\V1\AdController@purchasePromotion');
            Route::get('list_dashboard', 'Api\V1\AdController@listDashboard');
            Route::post('get_user_ads', 'Api\V1\AdController@getUserAd');
           
            Route::post('create_ad', 'Api\V1\AdController@createAd');
            Route::post('edit_ad', 'Api\V1\AdController@editAd');
            Route::post('extend_ad', 'Api\V1\AdController@extendDays');
            Route::post('ad_detail', 'Api\V1\AdController@getAdDetail');
            Route::post('like_unlike', 'Api\V1\AdController@likeUnlike');
            Route::get('my_favorites', 'Api\V1\AdController@getMyFavorites');
            Route::post('filter_ads', 'Api\V1\AdController@getFilterAds');
            Route::get('purchase_history', 'Api\V1\AdController@getPurchaseHistory');
            Route::post('delete_ad', 'Api\V1\AdController@deleteAd');
            Route::post('delete_temp_image', 'Api\V1\AdController@deleteTempImage');
            //Bids
            Route::get('get_my_bids', 'Api\V1\BidController@getMyBid');
            Route::post('pending_bids', 'Api\V1\BidController@getPendingBid');
            Route::post('approved_bids', 'Api\V1\BidController@getApprovedBid');
            Route::post('delete_bid', 'Api\V1\BidController@deleteBid');
            Route::post('approve_bid', 'Api\V1\BidController@approveBid');
            Route::post('add_bid', 'Api\V1\BidController@addBid');

            //Transaction
            Route::get('get_my_transactions', 'Api\V1\TransactionController@getMyTransaction');
            
            //General
            Route::post('contact_us', 'Api\V1\GeneralController@contactUs');

            //User
            Route::post('get_profile', 'Api\V1\UserController@profileInfo');
            Route::post('add_review','Api\V1\UserController@addReview');
            Route::post('change_password', 'Api\V1\UserController@changePassword');
            Route::post('change_language', 'Api\V1\UserController@changeLanguage');
            Route::post('add_card', 'Api\V1\UserController@addCard');
            Route::get('list_card', 'Api\V1\UserController@cardList');
            Route::post('add_amount', 'Api\V1\UserController@addAmount');
            Route::get('delete_account', 'Api\V1\UserController@deleteAccount');
            Route::post('logout','Api\V1\AuthController@logout');

            //Notifications
            Route::post('get_notification','Api\V1\NotificationController@getNotification');
            Route::post('delete_notification','Api\V1\NotificationController@deleteNotification');
    });
});
