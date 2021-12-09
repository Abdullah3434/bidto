<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear-cache', function() {
  Artisan::call('config:clear');
  Artisan::call('cache:clear');
  Artisan::call('route:clear');
  return "Cache is cleared";
});

  Route::group(['prefix' => 'admin', 'domain' => env('APP_DOMAIN'), 'namespace' => 'AdminAuth'], function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login');
    Route::post('/logout', 'LoginController@logout');
    Route::get('/logout', 'LoginController@logout');
  
    Route::get('/register', 'RegisterController@showRegistrationForm');
    Route::post('/register', 'RegisterController@register');
  
    Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ResetPasswordController@reset');
    Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'ResetPasswordController@showresetform')->name('reset.password.get');

  });

  Route::group(['domain' => env('APP_DOMAIN'), 'namespace' => 'Front\V1'], function () {
    Route::get('/under-development', 'GeneralController@underDevelopment');

    Route::group([ 'middleware' => ['iswebsiteavailable']], function () {

      Route::get('/register', 'AuthController@registerView');
      Route::post('/register', 'AuthController@register');
      Route::get('/code-verification', 'AuthController@codeVerificationView');
      Route::post('/code-verification', 'AuthController@codeVerification');
      Route::post('/resend-otp', 'AuthController@resendOtp');
      Route::get('/success-verification', 'AuthController@successVerificationView');

      Route::get('/login', 'AuthController@emailLoginView')->name('login');
      Route::get('/phone-login', 'AuthController@phoneLoginView')->name('phone_login');
      Route::post('/login', 'AuthController@login');
      Route::get('/logout', 'AuthController@logout');

      Route::get('/forgot-password', 'AuthController@emailForgotPasswordView');
      Route::post('/forgot-password', 'AuthController@forgotPassword');
      Route::get('/reset-verification', 'AuthController@resetVerificationView');
      Route::post('/reset-verification', 'AuthController@resetVerification');
      Route::get('/reset-password', 'AuthController@resetPasswordView');
      Route::post('/reset-password', 'AuthController@resetPassword');
      Route::get('/reset-success', 'AuthController@resetSuccessView');
      
      Route::get('/home', 'HomeController@index');
      Route::get('/', 'HomeController@index');
      Route::post('/filter-ajax-ads', 'AdController@filterAjaxAds');
      Route::get('/ad', 'AdController@adView');
      Route::get('/ad-detail', 'AdController@adDetail');

      Route::get('/get-langauge', 'GeneralController@getAjaxLanguage');
      Route::get('/get-category', 'GeneralController@getAjaxHomeCategory');
      Route::post('/change-language', 'GeneralController@changeLanguage');

      Route::get('/category', 'GeneralController@categoryView');
      Route::get('/get-ajax-category', 'GeneralController@getAjaxCategory');


      Route::post('/upload-image', 'AdController@uploadImage');
      Route::post('/create-ad', 'AdController@createAd');
      Route::post('/remove-image', 'AdController@removeUploadImage');
      Route::get('/get-ajax-ad-category', 'AdController@getAjaxAdCategory');
      Route::get('/get-ajax-ad-metadata', 'AdController@getAjaxAdMetaData');
      Route::get('/get-ajax-settings', 'GeneralController@getAjaxSettings');
      Route::post('/like-unlike', 'AdController@likeUnlike');

      Route::post('pending-bids', 'BidController@getPendingBid');
      Route::post('approved-bids', 'BidController@getApprovedBid');
      Route::post('add-bid', 'BidController@addBid');
    
  });
});

//Auth::routes();


