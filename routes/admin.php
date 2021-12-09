<?php
use App\Models\User;
use App\Models\Item; 
use App\Models\UserTransaction;

Route::get('/admin/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();
    // Route::get('/admin/home', 'DashboardController@view_cylinder');
    $all_users= User::all();
           $count_all=count($all_users);
   
      $active_users= User::where('status', "active")->get();
      $count_active= count($active_users);

      $all_items= Item::all();
           $count_item=count($all_items);

           $active_items= Item::where('status', "active")->get();
           $count_active_items= count($active_users);

           $total_services= Item::where('Item_type', "service")->get();
           $count_total_services= count($total_services);

           $total_item= Item::where('Item_type', "item")->get();
           $count_total_item= count($total_item);

           $total_requests= Item::where('Item_type', "request")->get();
           $count_total_requests= count($total_requests);

           $total_purchase= UserTransaction::where('transaction_type', "purchase_promotion")->get();
           $count_purchase= count($total_purchase);

           $sum_top_up = UserTransaction::where('transaction_type', 'add_balance')->sum('amount');

    return view('admin.home',compact('count_total_item','count_total_requests','count_total_services','sum_top_up','count_purchase','count_all','count_active','count_item','count_active_items'));
})->name('admin.home');

Route::group(['domain' => env('APP_DOMAIN'), 'namespace' => 'Admin'], function () {
//.....<<<<<<<<<<<<<<<<<<<<<<<<<<<<.........Category..........>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>.........//

  Route::get('/admin/category/add', 'CategoryController@add');
  Route::post('/admin/add/category', 'CategoryController@add_category');
  Route::get('/admin/categories/', 'CategoryController@view_category');
  Route::get('/status/{status}/{key}', 'CategoryController@status');
  Route::get('/admin/category/edit/{cat_key}', 'CategoryController@edit_category_view');
  Route::post('/admin/edit/category/{key}', 'CategoryController@edit_category');
  Route::get('/admin/delete/category/{cat_key}', 'CategoryController@delete_category');

//....<<<<<<<<<<<<<<<<<<<<<<<........... Color.........>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>...........//


Route::get('/admin/color/add', 'ColorController@add_color_view');
Route::post('/admin/add/color', 'ColorController@add_color');
Route::get('/admin/color/', 'ColorController@view_color');
Route::get('/admin/color/edit/{id}', 'ColorController@edit_color_view');
Route::post('/admin/edit/color/{id}', 'ColorController@edit_color');
Route::get('/admin/delete/color/{id}', 'ColorController@delete_color');

//.......<<<<<<<<<<<<<<........... Transmission.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/transmission/add', 'TransmissionController@add_transmission_view');
Route::post('/admin/add/transmission', 'TransmissionController@add_transmission');
Route::get('/admin/transmission/', 'TransmissionController@view_transmission');
Route::get('/admin/transmission/edit/{id}', 'TransmissionController@edit_transmission_view');
Route::post('/admin/edit/transmission/{id}', 'TransmissionController@edit_transmission');
Route::get('/admin/delete/transmission/{id}', 'TransmissionController@delete_transmission');

//.......<<<<<<<<<<<<<<........... Item Types.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/item-types/add', 'ItemTypeController@add_item_type_view');
Route::post('/admin/add/item_type', 'ItemTypeController@add_item_type');
Route::get('/admin/item-types/', 'ItemTypeController@view_item_type');
Route::get('/admin/item-types/edit/{key}', 'ItemTypeController@edit_item_type_view');
Route::post('/admin/edit/item-types/{key}', 'ItemTypeController@edit_item_type');
Route::get('/admin/delete/item-type/{key}', 'ItemTypeController@delete_item_type');

//.......<<<<<<<<<<<<<<........... Item Conditions.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/condition/add', 'ConditionController@add_condition_view');
Route::post('/admin/add/condition', 'ConditionController@add_condition');
Route::get('/admin/condition', 'ConditionController@view_condition');
Route::get('/admin/condition/edit/{id}', 'ConditionController@edit_condition_view');
Route::post('/admin/edit/condition/{id}', 'ConditionController@edit_condition');
Route::get('/admin/delete/condition/{id}', 'ConditionController@delete_condition');

//.......<<<<<<<<<<<<<<........... Item Cylinders.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/cylinder/add', 'CylinderController@add_cylinder_view');
Route::post('/admin/add/cylinder', 'CylinderController@add_cylinder');
Route::get('/admin/cylinder', 'CylinderController@view_cylinder');
Route::get('/admin/cylinder/edit/{id}', 'CylinderController@edit_cylinder_view');
Route::post('/admin/edit/cylinder/{id}', 'CylinderController@edit_cylinder');
Route::get('/admin/delete/cylinder/{id}', 'CylinderController@delete_cylinder');

//.......<<<<<<<<<<<<<<........... Item makes.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/make/add', 'MakeController@add_item_make_view');
Route::post('/admin/add/item/make', 'MakeController@add_item_make');
Route::get('/admin/makes', 'MakeController@view_item_make');
Route::get('/admin/make/edit/{id}', 'MakeController@edit_item_make_view');
Route::post('/admin/edit/item/make/{id}', 'MakeController@edit_item_make');
Route::get('/admin/delete/item/make/{id}', 'MakeController@delete_item_make');

//.......<<<<<<<<<<<<<<........... Item Models.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/model/add/{make_id}', 'MakeController@add_item_model_view');
Route::post('/admin/add/item/model/{make_id}', 'MakeController@add_item_model');
Route::get('/admin/models/{make_id}', 'MakeController@view_item_model');
Route::get('/admin/model/edit/{make_id}/{model_id}', 'MakeController@edit_item_model_view');
Route::post('/admin/edit/item/model/{make_id}/{model_id}', 'MakeController@edit_item_model');
Route::get('/admin/delete/item/model/{id}', 'MakeController@delete_item_model');

//.......<<<<<<<<<<<<<<........... Sponsors.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/sponsor/add', 'SponsorController@add_sponsor_view');
Route::post('/admin/add/sponsor', 'SponsorController@add_sponsor');
Route::get('/admin/sponsors', 'SponsorController@view_sponsors');
Route::get('/admin/sponsor/edit/{id}', 'SponsorController@edit_sponsor_view');
Route::post('/admin/edit/sponsor/{id}', 'SponsorController@edit_sponsor');
Route::get('/admin/delete/sponsor/{id}/{image}', 'SponsorController@delete_sponsor');

//.......<<<<<<<<<<<<<<........... Email Templates.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/email/templates', 'EmailController@view_email_templates');
Route::get('/admin/email-temp/edit/{id}', 'EmailController@edit_email_templates_view');
Route::post('/admin/edit/email-temp/{id}', 'EmailController@edit_email_template');

//.......<<<<<<<<<<<<<<........... Push Notifications.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/notification/templates', 'NotificationController@view_notification_templates');
Route::get('/admin/notification/template/edit/{id}', 'NotificationController@edit_notification_template_view');
Route::post('/admin/edit/notification/template/{id}', 'NotificationController@edit_notification_templates');

//.......<<<<<<<<<<<<<<........... Message Templates.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/message/templates', 'MessageController@view_message_templates');
Route::get('/admin/message-temp/edit/{id}', 'MessageController@edit_message_templates_view');
Route::post('/admin/edit/message-temp/{id}', 'MessageController@edit_message_template');

//.......<<<<<<<<<<<<<<........... Settings.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//

Route::get('/admin/settings', 'SettingController@view_settings');
Route::post('/admin/edit/setting', 'SettingController@edit_setting');

//.......<<<<<<<<<<<<<<........... Page Content.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/page/content', 'ContentController@view_page_contents');
Route::get('/admin/content/edit/{page_key}', 'ContentController@edit_page_content');
Route::post('/admin/edit/content/{key}', 'ContentController@edit_content');

//.......<<<<<<<<<<<<<<........... User Managment.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/users', 'ManageUserController@view_users');
Route::get('/admin/user/edit/{id}', 'ManageUserController@edit_user_view');
Route::post('/admin/edit/user/{id}', 'ManageUserController@edit_user');
Route::get('/admin/delete/user/{id}', 'ManageUserController@delete_user');
Route::get('/admin/users/status/{status}/{id}', 'ManageUserController@status');
Route::get('/admin/users/verify/{status}/{id}', 'ManageUserController@verify');

//.......<<<<<<<<<<<<<<........... User Reviews Managment.....>>>>>>>>>>>>>>>>>>>>>>>>>>>...........//


Route::get('/admin/user/reviews/{id}', 'UserReviewsController@view_reviews');
Route::get('/admin/reviews/edit/{id}/{user_id}', 'UserReviewsController@edit_reviews_view');
Route::post('/admin/edit/reviews/{id}/{user_id}', 'UserReviewsController@edit_reviews');
Route::get('/admin/delete/reviews/{id}', 'UserReviewsController@delete_reviews');
Route::get('/admin/user/reviews/status/{status}/{id}', 'UserReviewsController@status');

//.......<<<<<<<<<<<<<<........... User Transaction.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/user/transactions/{user_id}', 'UserBalanceController@view_transactions');
Route::get('/admin/transactions/edit/{id}/{user_id}', 'UserBalanceController@edit_transaction_view');
Route::post('/admin/edit/transactions/{id}/{user_id}', 'UserBalanceController@edit_transaction');
Route::get('/admin/delete/transaction/{id}', 'UserBalanceController@delete_transaction');

//.......<<<<<<<<<<<<<<........... User Credit Cards.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//


Route::get('/admin/user/cards/{user_id}', 'UserCardController@view_cards');
Route::get('/admin/user/card/status/{status}/{id}', 'UserCardController@status');
Route::get('/admin/card/edit/{id}/{user_id}', 'UserCardController@edit_card_view');
Route::post('/admin/edit/card/{id}/{user_id}', 'UserCardController@edit_card');
Route::get('/admin/delete/card/{id}', 'UserCardController@delete_card');

//.......<<<<<<<<<<<<<<........... User Chat.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//



Route::get('/admin/user/chat-thread/{id}', 'UserChatController@view_threads');
Route::get('/admin/users/chat/{id}/{from_id}/{to_id}', 'UserChatController@view_chat');
Route::get('/admin/delete/chat/{id}', 'UserChatController@delete_chat');

//.......<<<<<<<<<<<<<<........... Item Managment.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//
Route::get('/ajax-subcategory','ItemController@myformAjax');

// Route::get('/ajax-sub','ItemController@myformAjax2');

Route::get('/admin/items', 'ItemController@view_item');
Route::get('/admin/item/edit/{id}', 'ItemController@edit_item_view');
Route::post('/admin/edit/item/{id}/{type}', 'ItemController@edit_item');
Route::get('/admin/delete/item/{id}', 'ItemController@delete_item');
Route::get('/admin/item/status/{status}/{id}', 'ItemController@status');
Route::get('/admin/item/images/{id}', 'ItemController@view_images');
Route::get('/admin/delete/item/image/{id}', 'ItemController@delete_image');

Route::get('/admin/item/bids/{id}', 'ItemController@view_bids');
Route::get('/admin/item/delete/bid/{id}', 'ItemController@delete_bid');
Route::get('/admin/item/bids/edit/{id}', 'ItemController@edit_bid_view');
Route::post('/admin/item/edit/bid/{id}/{item_id}', 'ItemController@edit_bid');
Route::post('/admin/item/update/bid/status/{id}', 'ItemController@bid_status');

//.>>>>>>>>>>>>>>>>>.........Manage Service........>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>///

Route::get('/admin/services', 'ManageServiceController@view_services');
Route::get('/admin/service/status/{status}/{id}', 'ManageServiceController@status');
Route::get('/admin/service/edit/{id}', 'ManageServiceController@edit_item_view');
Route::post('/admin/edit/service/{id}/{type}', 'ManageServiceController@edit_item');
Route::get('/admin/delete/service/{id}', 'ManageServiceController@delete_item');
Route::get('/admin/service/images/{id}', 'ManageServiceController@view_images');
Route::get('/admin/delete/service/image/{id}', 'ManageServiceController@delete_image');

Route::get('/admin/service/bids/{id}', 'ManageServiceController@view_bids');
Route::get('/admin/service/delete/bid/{id}', 'ManageServiceController@delete_bid');
Route::get('/admin/service/bids/edit/{id}', 'ManageServiceController@edit_bid_view');
Route::post('/admin/service/edit/bid/{id}/{item_id}', 'ManageServiceController@edit_bid');
Route::post('/admin/service/update/bid/status/{id}', 'ManageServiceController@bid_status');

//.>>>>>>>>>>>>>>>>>.........Manage Request........>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>///

Route::get('/admin/requests', 'ManageRequestController@view_requests');
Route::get('/admin/request/status/{status}/{id}', 'ManageRequestController@status');
Route::get('/admin/request/edit/{id}', 'ManageRequestController@edit_request_view');
Route::post('/admin/edit/request/{id}/{type}', 'ManageRequestController@edit_request');
Route::get('/admin/delete/request/{id}', 'ManageRequestController@delete_request');
Route::get('/admin/request/images/{id}', 'ManageRequestController@view_images');
Route::get('/admin/delete/request/image/{id}', 'ManageRequestController@delete_image');

Route::get('/admin/request/bids/{id}', 'ManageRequestController@view_bids');
Route::get('/admin/request/delete/bid/{id}', 'ManageRequestController@delete_bid');
Route::get('/admin/request/bids/edit/{id}', 'ManageRequestController@edit_bid_view');
Route::post('/admin/request/edit/bid/{id}/{item_id}', 'ManageRequestController@edit_bid');
Route::post('/admin/request/update/bid/status/{id}', 'ManageRequestController@bid_status');

//.......<<<<<<<<<<<<<<........... Item Bids.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//




//.......<<<<<<<<<<<<<<........... Profile.....>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>..............//

Route::get('/admin/profile', 'ProfileController@edit_profile_view');
Route::post('/admin/profile/edit', 'ProfileController@edit_profile');

Route::get('/admin/change/password', 'ProfileController@change_pass_view');
Route::post('/admin/change/password', 'ProfileController@change_pass');





}); 