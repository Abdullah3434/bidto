<!DOCTYPE html>
@if(Session::get('lang_key')=='ar')
    <html class="rtl" lang="ar" dir="rtl">
@else
    <html>
@endif
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=0">
<title>@if(isset($meta_title) && @$meta_title!=''){{ @$meta_title}}@else{{settingValue('app_name')}}@endif</title>

<!--favicon-->
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('public/front_assets/images/favicon/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('public/front_assets/images/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/front_assets/images/favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('public/front_assets/images/favicon/site.webmanifest')}}">
<link rel="mask-icon" href="{{asset('public/front_assets/images/favicon/safari-pinned-tab.svg')}}" color="#81e1ba">
<meta name="msapplication-TileColor" content="#81e1ba">
<meta name="theme-color" content="#ffffff">
<!--favicon-->

<!--meta data-->
<meta name="csrf-token" content="{{csrf_token()}}">
@if(isset($meta_description) && @$meta_description!='')
    <meta name="description" content={{ @$meta_description}}>
@endif
@if(isset($meta_keywords) && @$meta_keywords!='')
    <meta name="keywords" content={{ @$meta_keywords}}>
@endif
<!--meta data-->

<!--Cairo, Poppins Google fonts-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
<!--Cairo, Poppins Google fonts end-->

<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/xzoom.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/responsive.css')}}">
@if(Session::get('lang_key')=='ar')
    <link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/rtl.css')}}">
@endif
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/ion.rangeSlider.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/font-awesome.min.css')}}">
<script src="{{asset('public/front_assets/js/jquery-3.5.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/front_assets/js/jquery.mask.js')}}"></script>
<script type="text/javascript" src="{{asset('public/front_assets/js/ion.rangeSlider.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/front_assets/js/my_script.js')}}"></script>
</head>
<script>
    var APP_URL = "{{ url('/') }}";
</script>
<body class="home_body">
<div class="wrapper">
  <header role="header" class="header">
    @include('front.layout.header')
  </header>
  <div class="left_menu">
    @include('front.layout.sidebar')
  </div>
  <main class="content" role="main">
    @yield('content')
  </main>
</div>

<!--sort filter popup-->
<div class="side_popup side_sort_popup">
  <div class="side_popup_whitebox">
    <div class="side_popup_heading">
      <h2>{{Lang::get("label.Sort by")}} <a class="side_popup_back_arrow" href="javascript:void(0)"></a></h2>
    </div>
    <div class="side_popup_content">
      <div class="sort_popup_list">
            @include('front.layout.sort_popup')
      </div>
    </div>
    <div class="side_popup_footer"> 
        <a class="all_buttons all_green" href="javascript:void(0)" onclick="sort_result(this)">{{Lang::get("label.Sort Results")}} </a>
    </div>
  </div>
  <div class="side_popup_overlay"></div>
</div>

<!--filter ads popup-->
<div class="side_popup side_filter_popup">
  <div class="side_popup_whitebox">
    <div class="side_popup_heading">
      <h2>{{Lang::get("label.Filters")}} <a class="side_popup_back_arrow" href="javascript:void(0)"></a></h2>
    </div>
    <div class="side_popup_content">
      <div class="filter_search_row">
        <div class="form_field has_search_icon">
          <input type="text" name="key" id="search_key" value="">
        </div>
      </div>
      <div class="filter_categories">
        <h3 class="side_filter_title_text">{{Lang::get("label.Show Categories")}}</h3>
        <ul id="ajax_categories">
          
        </ul>
      </div>
      <h3 class="side_filter_title_text">{{Lang::get("label.Price Range")}}</h3>
      <div class="side_priceRange_row">
        <input type="text" class="side_priceRange_slider" name="my_range" value="" />
      </div>
      <!--<h3 class="side_filter_title_text">Show</h3>
        <div class="side_filter_auctions_row">
            <ul>
            <li>
                <div class="form_checkbox checkbox_dark_color inline_checkbox">
                <label> Auctions
                    <input data-id="everyone" type="checkbox">
                    <span class="checkbox_checked"></span> </label>
                </div>
            </li>
            <li>
                <div class="form_checkbox checkbox_dark_color inline_checkbox">
                <label> Direct Buy
                    <input data-id="everyone" type="checkbox">
                    <span class="checkbox_checked"></span> </label>
                </div>
            </li>
            <li>
                <div class="form_checkbox checkbox_dark_color inline_checkbox">
                <label> Bided
                    <input data-id="everyone" type="checkbox">
                    <span class="checkbox_checked"></span> </label>
                </div>
            </li>
            </ul>
        </div>-->
    </div>
    <div class="side_popup_footer"> 
        <a class="all_buttons all_green" href="javascript:void(0)" onclick="filter_result(this)">{{Lang::get("label.Filter Results")}}</a> 
    </div>
  </div>
  <div class="side_popup_overlay"></div>
</div>

<!--Pick Service Type popup-->
<div class="all_popup serviceType_popup">
  <div class="popup_table_wrap">
    <div class="popup_cell_wrap">
      <div class="popup_auto">
        <div class="popup_detail">
          <div class="popup_content">
              <a class="popup_mob_close" href="javascript:void(0)"></a> 
              <strong class="popup_title_heading">{{Lang::get("label.Pick Service Type")}}</strong>
            <div class="pick_service_type_list">
              <ul>
                <li>
                  <div class="pick_service_box">
                    <div class="pick_service_cell">
                      <input class="pick_service_check pick_service_check_item" type="radio" name="item_type" value="item">
                      <i class="pick_service_icon_item"></i> 
                      <strong>{{Lang::get("label.Item")}}</strong> 
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pick_service_box">
                    <input class="pick_service_check pick_service_check_service" type="radio" name="item_type" value="service">
                    <div class="pick_service_cell"> 
                        <i class="pick_service_icon_service"></i> 
                        <strong>{{Lang::get("label.Service")}}</strong> 
                    </div>
                  </div>
                </li>
                <li>
                  <div class="pick_service_box">
                    <input class="pick_service_check pick_service_check_request" type="radio" name="item_type" value="request">
                    <div class="pick_service_cell"> 
                        <i class="pick_service_icon_request"></i> 
                        <strong>{{Lang::get("label.Request")}}</strong> 
                    </div>
                  </div>
                </li>
              </ul>
              <!--<div class="pick_item_proceed_out"> 
                  <a class="pick_item_proceed_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Proceed")}}</a> 
              </div>-->
            </div>
          </div>
        </div>
      </div>
      <div class="popup_overlay"></div>
    </div>
  </div>
</div>
<!--Pick Service Type popup--> 

<!--add images popup start-->
<div class="all_popup add_images_popup">
  <div class="popup_table_wrap">
    <div class="popup_cell_wrap">
      <div class="popup_auto">
        <div class="popup_detail">
          <div class="popup_content">
              <a class="popup_mob_close" href="javascript:void(0)"></a> 
              <strong class="popup_title_heading">{{Lang::get("label.Add Images")}}</strong>
            <div class="uploadImages_row">
              <div class="new_list_progress">
                <div class="new_list_progress_bar"></div>
              </div>
              <div class="uploadImage_box">
                <div class="uploadImage_box_inner">
                    <form method="post" enctype="multipart/form-data" action="{{url('/upload-image')}}" id="add_images_form">
                        {{ csrf_field() }}
                        <input type="file" name="ad_image">
                    </form>
                  
                    
                  <strong>{{Lang::get("label.Upload Image")}}</strong> 
                  <small>{!!Lang::get("label.Click to select the images with <br>max size 2 mb")!!}</small> 
                </div>
              </div>
              <div class="uploading_images_list">
                <div class="uploading_images_errorMsg" style=""></div>
                <ul>
                  
                </ul>
              </div>
              <div class="pick_item_proceed_out"> 
                  <a class="pick_item_addImages_next_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Item Info")}}</a> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="popup_overlay"></div>
    </div>
  </div>
</div>
<!--add images popup end--> 

<!-- item title info popup start-->
<div class="all_popup item_title_info_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a> 
                        <strong class="popup_title_heading">{{Lang::get("label.Item Info")}}</strong>
                        <div class="uploadImages_row">
                            <div class="new_list_progress">
                                <div class="new_list_progress_bar" style="width:66.66%"></div>
                            </div>
                            <div class="item_info_form has_dark_placeholder">
                                <div class="formParent">
                                    <div class="formRow clearfix">
                                        <div class="formCell col12">
                                            <div class="selectbox"> 
                                                <span class="selectbox_span" >{{Lang::get("label.Category")}}</span>
                                                <select class="dropdown_category" id="dropdown_category"  name="ad_category" onchange="change_dropdown_category(this)">
                                                    
                                                </select>
                                            </div>
                                           
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <input class="" type="text" placeholder="{{Lang::get('label.Title')}}" name="ad_title" id="ad_title">
                                            </div>
                                           
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <textarea class="" placeholder="{{Lang::get('label.Description')}}" name="ad_desc" id="ad_desc"></textarea>
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <input name="ad_loc" class="" type="text"  placeholder="{{Lang::get('label.Preferred Location')}}" id="item_title_info_popup_preferred_location" value="">
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form-group">
                                                <label class="col-md-3"></label>
                                                <div class="col-md-9">
                                                    <div id="item_title_info_popup_map" style="height: 200px; width: 100%"></div>
                                                    <input type="hidden" name="ad_latitude" id="item_title_info_popup_latitude" value="0.0000000">
                                                    <input type="hidden" name="ad_longitude" id="item_title_info_popup_longitude" value="0.0000000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pick_item_proceed_out"> 
                                <a class="pick_item_iteminfo_next_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Item Info")}}</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--request item info popup end-->
<!--item info popup start-->
<div class="all_popup item_info_popup">
  <div class="popup_table_wrap">
    <div class="popup_cell_wrap">
      <div class="popup_auto">
        <div class="popup_detail">
          <div class="popup_content">
              <a class="popup_mob_close" href="javascript:void(0)"></a> 
              <strong class="popup_title_heading">{{Lang::get("label.Item Info")}}</strong>
            <div class="uploadImages_row">
              <div class="new_list_progress">
                <div class="new_list_progress_bar" style="width:66.66%"></div>
              </div>
              <div class="item_info_form has_dark_placeholder">
                <div class="formParent">
                    
                </div>
              </div>
              <div class="pick_item_proceed_out"> 
                  <a class="pick_item_promotion_next_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Promotion")}}</a> 
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="popup_overlay"></div>
    </div>
  </div>
</div>
<!--item info popup end--> 

<!--service item info popup start-->
<div class="all_popup service_item_info_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a> 
                        <strong class="popup_title_heading">{{Lang::get("label.Service Info")}}</strong>
                        <div class="uploadImages_row">
                            <div class="new_list_progress">
                                <div class="new_list_progress_bar" style="width:50%"></div>
                            </div>
                            <div class="item_info_form has_dark_placeholder">
                                <div class="formParent">
                                    <div class="formRow clearfix">
                                        <div class="formCell col12">
                                            <div class="selectbox"> 
                                                <span class="selectbox_span">{{Lang::get("label.Category")}}</span>
                                                <select class="dropdown_category" id="dropdown_category"  name="ad_category" onchange="change_dropdown_category(this)">
                                                        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <input type="text" placeholder="{{Lang::get('label.Title')}}" name="ad_title" id="ad_title">
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <textarea placeholder="{{Lang::get('label.Description')}}" name="ad_desc" id="ad_desc"></textarea>
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <input name="ad_loc" class="" type="text" placeholder="{{Lang::get('label.Preferred Location')}}" id="service_item_info_popup_preferred_location" value="">
                                                
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form-group">
                                                <label class="col-md-3"></label>
                                                <div class="col-md-9">
                                                    <div id="service_item_info_popup_map" style="height: 200px; width: 100%"></div>
                                                    <input type="hidden" name="ad_latitude" id="service_item_info_popup_latitude" value="0.0000000">
                                                    <input type="hidden" name="ad_longitude" id="service_item_info_popup_longitude" value="0.0000000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pick_item_proceed_out"> 
                                <a class="pick_item_iteminfo_next_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Promotion")}}</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--service item info popup end--> 

<!--request item info popup start-->
<div class="all_popup request_item_info_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a> 
                        <strong class="popup_title_heading">{{Lang::get("label.Request Info")}}</strong>
                        <div class="uploadImages_row">
                            <div class="new_list_progress">
                                <div class="new_list_progress_bar" style="width:66.66%"></div>
                            </div>
                            <div class="item_info_form has_dark_placeholder">
                                <div class="formParent">
                                    <div class="formRow clearfix">
                                        <div class="formCell col12">
                                            <div class="selectbox"> 
                                                <span class="selectbox_span">{{Lang::get("label.Category")}}</span>
                                                <select class="dropdown_category" id="dropdown_category"  name="ad_category" onchange="change_dropdown_category(this)">
                                                        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <input name="ad_title" id="ad_title" type="text" placeholder="{{Lang::get('label.Title')}}">
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <textarea name="ad_desc" id="ad_desc" placeholder="{{Lang::get('label.Description')}}"></textarea>
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form_field">
                                                <input  name="ad_loc" class="" type="text" placeholder="{{Lang::get('label.Preferred Location')}}" id="request_item_info_popup_preferred_location" value="">
                                                
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="form-group">
                                                <label class="col-md-3"></label>
                                                <div class="col-md-9">
                                                    <div id="request_item_info_popup_map" style="height: 200px; width: 100%"></div>
                                                    <input type="hidden" name="ad_latitude" id="request_item_info_popup_latitude" value="0.0000000">
                                                    <input type="hidden" name="ad_longitude" id="request_item_info_popup_longitude" value="0.0000000">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="formCell col6">
                                            <div class="form_field">
                                                <input name="ad_price_from" id="ad_price_from" class="" type="text" placeholder="{{Lang::get('label.Price From')}}">
                                            </div>
                                        </div>
                                        <div class="formCell col6">
                                            <div class="form_field">
                                                <input name="ad_price_to" id="ad_price_to" class=""  type="text" placeholder="{{Lang::get('label.Price To')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pick_item_proceed_out"> 
                                <a class="pick_item_iteminfo_next_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Promotion")}}</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--request item info popup end--> 


<!--item promotion popup start-->
<div class="all_popup item_promotion_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a> 
                        <strong class="popup_title_heading">{{Lang::get("label.Promotion")}}</strong>
                        <div class="uploadImages_row">
                            <div class="new_list_progress">
                                <div class="new_list_progress_bar" style="width:100%"></div>
                            </div>
                            <div class="itemPromo_form">
                                <div class="itemPromo_enable_row"> 
                                    <strong>{{Lang::get("label.Enable Promotion")}}</strong>
                                    <div class="itemPromo_enable_switch">
                                        <input class="itemPromo_enable_switch_check" type="checkbox">
                                        <label> 
                                            <i class="itemPromo_switch_tick"></i> 
                                            <i class="itemPromo_switch_block"></i> 
                                        </label>
                                    </div>
                                </div>
                                <div class="formParent">
                                    <div class="formRow clearfix">
                                        <div class="formCell col12">
                                            <p class="promotion_popup_text">{{Lang::get('label.Promotion Days')}} <strong>60 {{Lang::get('label.days')}}</strong></p>
                                        </div>
                                        <div class="formCell col12">
                                            <div class="itemPromo_useBlnce_main">
                                                <div class="form_checkbox checkbox_dark_color pad0">
                                                    <label class="pad0"> 
                                                        <em class="userBlnce_txt"> 
                                                            <strong></strong>
                                                            <small ></small>
                                                        </em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                     
                                        <div class="formCell col12">
                                            <div class="itemPromo_price"> 
                                                <small></small>
                                                <h2> <span></span></h2>
                                            </div>
                                        </div>
                                        <div class="formCell col12">
                                            
                                            <p class="promotion_popup_text promotion_popup_text_end_date">Your promotion will expire on 17, January 2022</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pick_item_proceed_out"> 
                                <a class="pick_item_promo_next_btn all_buttons has_proceed_icon all_green has_icon" href="javascript:void(0)">{{Lang::get("label.Create Listing")}}</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--item promotion popup end--> 

<!--item added popup start-->
<div class="all_popup item_added_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="uploadImages_row">
                            <div class="itemAdded_box">
                                <div class="deal_list_box">
                                    <div class="deal_list_img"> 
                                        <a href="javascript:void(0)">
                                           
                                        </a> 
                                        <a class="bookmark_item_star active" href="javascript:void(0)"></a> 
                                    </div>
                                    <div class="deal_list_detail">
                                        <h3>
                                            <a href="javascript:void(0)"></a>
                                        </h3>
                                        <div class="deal_list_auther"> 
                                            
                                        </div>
                                        <div class="deal_list_price"> 
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="itemAdded_heading">
                               
                            </div>
                            <div class="pick_item_proceed_out"> 
                                <a class="pick_item_promo_next_btn all_buttons btn_block lignt_green" href="javascript:void(0)" onclick="goToStorePage()">{{Lang::get("label.Store Page")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--item added popup end--> 

<!--service added popup start-->
<div class="all_popup service_added_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="uploadImages_row">
                            <div class="serviceAdded_box">
                                <h3></h3>
                                <p></p>
                            </div>
                            <div class="itemAdded_heading">
                                
                            </div>
                            <div class="pick_item_proceed_out"> 
                                <a class="pick_item_promo_next_btn all_buttons btn_block lignt_green" href="javascript:void(0)" onclick="goToStorePage()">{{Lang::get("label.Store Page")}}</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--service added popup end--> 

<!--""""""""""""""""""""""all settings popup's html below""""""""""""""""""""""""--> 

<!--settings popup start-->
<div class="all_popup settings_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a> 
                        <strong class="popup_title_heading">{{Lang::get("label.Settings")}}</strong>
                        <div class="uploadImages_row">
                            <div class="settings_pop_lists">
                                @include('front.layout.settings_popup')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--settings popup end--> 

<!--language select popup start-->
<div class="all_popup language_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <strong class="popup_title_heading">{{Lang::get("label.Select Language")}} 
                            <small>{{Lang::get("label.Select your preferred app language")}}</small> 
                        </strong>
                        <div class="pick_service_type_list lang_check_main ">
                            <ul id="ajax_languages">
                                
                            </ul>
                            <div class="pick_item_proceed_out"> 
                                <a class="lang_popup_addNewBitBtn all_buttons btn_block lignt_green" href="javascript:void(0)" onclick="change_language(this)">{{Lang::get("label.Change Language")}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--language select popup end--> 

<!--delete account confirmation popup start-->
<div class="all_popup small_popup delete_account_confirmation_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="confirmation_text">
                            <h2>{{Lang::get("label.Delete Account?")}}</h2>
                            <p>{{Lang::get("label.Are you sure you want to delete your account, that will remove all saved data and bid you've made earlier")}}</p>
                            <div class="formRow clearfix">
                                <div class="formCell col6">
                                    <a class="cancelBtn all_buttons btn_block green_border" href="javascript:void(0)">{{Lang::get("label.Cancel")}}</a>
                                </div>
                                <div class="formCell col6">
                                    <a class="accountDeleteBtn all_buttons btn_block lignt_green" href="javascript:void(0)">{{Lang::get("label.Delete")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--delete account confirmation popup end--> 

<!--delete account confirmation popup start-->
<div class="all_popup small_popup account_deleted_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="confirmation_text">
                            <div class="account_deleted_circle"> 
                                <img src="{{asset('public/front_assets/images/account_deleted_circle.svg')}}" alt="#"> 
                            </div>
                            <h2>{{Lang::get("label.Account Deleted!")}}</h2>
                            <p>{{Lang::get("label.Your account has been deleted successfully and all data was terminated")}}</p>
                            <div class="formRow clearfix">
                                <div class="formCell col12">
                                    <a class="accountDleted_backBtn all_buttons btn_block lignt_green" href="login_with_email.html">{{Lang::get("label.Back to Login")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay" style="pointer-events: none;"></div>
        </div>
    </div>
</div>
<!--delete account confirmation popup end--> 

<!--""""""""""""""""""""""all settings popup's html end""""""""""""""""""""""""--> 

<!--Block User popup start-->
<div class="all_popup small_popup block_user_confirmation_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="confirmation_text">
                            <h2>{{Lang::get("label.Block User")}}</h2>
                            <p>{{Lang::get("label.Are you sure you want to block this user, he won't see your ads or be able to bid")}}</p>
                            <div class="formRow clearfix">
                                <div class="formCell col6">
                                    <a class="cancelBtn all_buttons btn_block green_border" href="javascript:void(0)">{{Lang::get("label.Cancel")}}</a>
                                </div>
                                <div class="formCell col6">
                                    <a class="blockUserBtn all_buttons btn_block lignt_green" href="javascript:void(0)">{{Lang::get("label.Block")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--Block User popup end--> 

<!--User Blocked popup start-->
<div class="all_popup small_popup user_blocked_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="confirmation_text">
                            <div class="account_deleted_circle"> 
                                <img src="{{asset('public/front_assets/images/account_deleted_circle.svg')}}" alt="#">
                            </div>
                            <h2>{{Lang::get("label.User Blocked")}}</h2>
                            <p>{{Lang::get("label.This user has been blocked and won't see your ads or bid at them anymore")}}</p>
                            <div class="formRow clearfix">
                                <div class="formCell col12">
                                    <a class="accountDleted_backBtn all_buttons btn_block lignt_green" href="home_buyer.html">{{Lang::get("label.Back to Home")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay" style="pointer-events: none;"></div>
        </div>  
    </div>
</div>
<!--User Blocked popup end--> 

<!--Rate User popup start-->
<div class="all_popup small_popup rate_user_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="confirmation_text">
                            <h2>{{Lang::get("label.Rate User")}}</h2>
                            <p>{{Lang::get("label.Are you sure you want to block this user, he won't see your ads or be able to bid")}}</p>
                            <div class="rateUser_stars_row clearfix">
                                <fieldset class="rating">
                                    <input type="radio" id="star5" name="rating" value="{{Lang::get('label.5')}}" />
                                    <label class = "full" for="star5" title="{{Lang::get('label.Awesome - 5 stars')}}"></label>
                                    <input type="radio" id="star4half" name="rating" value="{{Lang::get('label.4 and a half')}}" />
                                    <label class="half" for="star4half" title="{{Lang::get('label.Pretty good - 4.5 stars')}}"></label>
                                    <input type="radio" id="star4" name="rating" value="{{Lang::get('label.4')}}" />
                                    <label class = "full" for="star4" title="{{Lang::get('label.Pretty good - 4 stars')}}"></label>
                                    <input type="radio" id="star3half" name="rating" value="{{Lang::get('label.3 and a half')}}" />
                                    <label class="half" for="star3half" title="{{Lang::get('label.Meh - 3.5 stars')}}"></label>
                                    <input type="radio" id="star3" name="rating" value="{{Lang::get('label.3')}}" />
                                    <label class = "full" for="star3" title="{{Lang::get('label.Meh - 3 stars')}}"></label>
                                    <input type="radio" id="star2half" name="rating" value="{{Lang::get('label.2 and a half')}}" />
                                    <label class="half" for="star2half" title="{{Lang::get('label.Kinda bad - 2.5 stars')}}"></label>
                                    <input type="radio" id="star2" name="rating" value="{{Lang::get('label.2')}}" />
                                    <label class = "full" for="star2" title="{{Lang::get('label.Kinda bad - 2 stars')}}"></label>
                                    <input type="radio" id="star1half" name="rating" value="{{Lang::get('label.1 and a half')}}" />
                                    <label class="half" for="star1half" title="{{Lang::get('label.Meh - 1.5 stars')}}"></label>
                                    <input type="radio" id="star1" name="rating" value="{{Lang::get('label.1')}}" />
                                    <label class = "full" for="star1" title="{{Lang::get('label.Sucks big time - 1 star')}}"></label>
                                    <input type="radio" id="starhalf" name="rating" value="{{Lang::get('label.half')}}" />
                                    <label class="half" for="starhalf" title="{{Lang::get('label.Sucks big time - 0.5 stars')}}"></label>
                                </fieldset>
                            </div>
                            <div class="formRow rate_userPopup_area_row clearfix">
                                <div class="formCell col12">
                                    <div class="form_field">
                                        <textarea placeholder="{{Lang::get('label.Tell us more about your experience ..')}}" class="rate_userPopup_area"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="formRow clearfix">
                                <div class="formCell col6">
                                    <a class="cancelBtn all_buttons btn_block green_border" href="javascript:void(0)">{{Lang::get("label.Cancel")}}</a>
                                </div>
                                <div class="formCell col6">
                                    <a class="rateUserPopupBtn all_buttons btn_block lignt_green" href="javascript:void(0)">{{Lang::get("label.Rate User")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay"></div>
        </div>
    </div>
</div>
<!--Rate User popup end--> 

<!--User Blocked popup start-->
<div class="all_popup small_popup user_blocked_popup">
    <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
            <div class="popup_auto">
                <div class="popup_detail">
                    <div class="popup_content">
                        <a class="popup_mob_close" href="javascript:void(0)"></a>
                        <div class="confirmation_text">
                            <div class="account_deleted_circle"> 
                                <img src="{{asset('public/front_assets/images/review_recived_circle.svg')}}" alt="#"> 
                            </div>
                            <h2>{{Lang::get("label.Review Received")}}</h2>
                            <p>{{Lang::get("label.Your review has been received and will be published once confirmed")}} </p>
                            <div class="formRow clearfix">
                                <div class="formCell col12">
                                    <a class="accountDleted_backBtn all_buttons btn_block lignt_green" href="login_with_email.html">{{Lang::get("label.Back to Login")}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="popup_overlay" style="pointer-events: none;"></div>
        </div>
    </div>
</div>
<!--User Blocked popup end--> 
</body>
<script type="text/javascript" src="{{asset('public/front_assets/js/slick.min.js')}}"></script>
<script type="text/javascript" src="{{asset('public/front_assets/js/xzoom.min.js')}}"></script>
@if(@session()->get('lang_key') == 'ar')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuSHbRvdSMa6ymI5UurUBYMiKalT6uPbg&language=ar&libraries=places"></script>
@else
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCuSHbRvdSMa6ymI5UurUBYMiKalT6uPbg&language=en&libraries=places"></script>
@endif
@yield('javascript')

<script type="text/javascript">

        var myLatLng = {lat: 31.5204, lng: 74.3587};
        var lat = 31.5204;
        var long =74.3587;

       var home_ad_page = 0;
       var home_ad_limit = 1;
       var home_ad_empty_rec= false;
       var home_ad_sort_by ='new_items';
       var home_ad_is_selling= 0;
       var home_ad_type ='item';
       var home_ad_category ='all';
       var home_ad_search_key = '';
       var home_ad_from_price = {{Session::get('min_price_filter')}};
       var home_ad_to_price = {{Session::get('max_price_filter')}};
       var is_range_move =0;
       var settings_params = '';

      
       var create_ad_item_type = 'item';
       var create_ad_name = '';
       var create_ad_description = '';
       var create_ad_category = '';
       var create_ad_condition = '';
       var create_ad_make = '';
       var create_ad_model= '';
       var create_ad_max_price = '';
       var create_ad_year = '';
       var create_ad_interior_color = '';
       var create_ad_exterior_color = '';
       var create_ad_transmission = '';
       var create_ad_no_of_cylinders = '';
       var create_ad_price_from = '';
       var create_ad_price_to = '';
       var create_ad_location = '';
       var create_ad_latitude = '';
       var create_ad_longitude = '';
       var create_ad_is_promotion = 0;
       var create_ad_item_photos = [];
       var create_ad_type = '';
       
    $(".side_priceRange_slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 100000,
        postfix: " {{Session::get('currency')}} ",
        from_min :home_ad_from_price,
        from: home_ad_from_price,
        to: home_ad_to_price,
        onStart: function (data) {
            // fired then range slider is ready
           
        },
        onChange: function (data) {
            // fired on every range slider update
            
        },
        onFinish: function (data) {
            // fired on pointer release
            home_ad_from_price = data.from;
            home_ad_to_price = data.to;
            is_range_move = 1;
        },
        onUpdate: function (data) {
            // fired on changing slider with Update method
           
        }
    });

    $(document).ready(function(e) { 
        //first popup to select item types
        $(".filter_addNewList_btn").click(function() {
            $(".serviceType_popup").show();
            create_ad_item_type = 'item';
            create_ad_item_photos = [];
            $('.pick_service_check').parents('.pick_service_box').removeClass('active');
            $("html, body").addClass("popup_hidden");
        });
        //second popup to select images
        $(".pick_service_check").click(function() {
            $(".serviceType_popup").hide();
            $(".add_images_popup").show();
            create_ad_item_type = $('.pick_service_box').find('input[name="item_type"]:checked').val();
            $("html, body").addClass("popup_hidden");
           
        });
        //third popup to get info
        $(".pick_item_addImages_next_btn").click(function() {
            $(".all_popup").hide();
           if($(".pick_service_check_item").prop("checked") === true){ 
               $(".item_title_info_popup").show(); 
               get_category_popup_dropdown('item_title_info_popup');
               create_map(myLatLng,'item_title_info_popup');
                $('#item_title_info_popup_preferred_location').focus(function (e) {
                    initMap('item_title_info_popup');
                });
           } 
           else if($(".pick_service_check_request").prop("checked") === true){   
               $(".request_item_info_popup").show();
               get_category_popup_dropdown('request_item_info_popup');
               create_map(myLatLng,'request_item_info_popup');
                $('#request_item_info_popup_preferred_location').focus(function (e) {
                    initMap('request_item_info_popup');
                });
                
           }
           else if($(".pick_service_check_service").prop("checked") === true){    
               $(".service_item_info_popup").show();
               get_category_popup_dropdown('service_item_info_popup');
               create_map(myLatLng,'service_item_info_popup');
                $('#service_item_info_popup_preferred_location').focus(function (e) {
                     initMap('service_item_info_popup');
                });
                
           }
           
           $("html, body").addClass("popup_hidden");
           
           
           
           
       });
       //4th popup to get meta info of item but promotion for request and service 
        $(".pick_item_iteminfo_next_btn").click(function() {
            var class_name = 'item_title_info_popup';
            if($(".pick_service_check_item").prop("checked") === true){
                class_name = 'item_title_info_popup';
            }else if($(".pick_service_check_request").prop("checked") === true){
                class_name = 'request_item_info_popup';
            }else if($(".pick_service_check_service").prop("checked") === true){
                class_name = 'service_item_info_popup';
            }
            if(checkAdInfoValidation(class_name)){
                $(".all_popup").hide();
                if($(".pick_service_check_item").prop("checked") === true){
                    $(".item_info_popup").show();
                    get_all_meta_item_data();
                }else{
                    $(".item_promotion_popup").show();
                    get_promotion_settings();
                }
                
                $("html, body").addClass("popup_hidden");
            }
        });
        //popup to show promotion after item
        $('.pick_item_promotion_next_btn').click(function(){
            if(checkAdMetaDataValidation('item_info_popup')){
                $(".all_popup").hide();
                $(".item_promotion_popup").show();
                $("html, body").addClass("popup_hidden");
                get_promotion_settings();
            }
            
        });
        //popup to show success message
        $(".pick_item_promo_next_btn").click(function() {
            $('.item_promotion_popup').find('.item_promotion_error').remove();
            create_new_ad();
        });
        //on clicking upload image icon and restrict to 6 images
        $('.add_images_popup').find('input[name="ad_image"]').click(function(event){
            if(create_ad_item_photos.length<=4){

            }else{
                event.preventDefault();
            }
        });
        //to upload images as temporary files
        $('.add_images_popup').find('input[name="ad_image"]').change(function(e) {
            $('.uploading_images_errorMsg').html('');
            $('.uploading_images_errorMsg').hide();
            $('.add_images_popup').find('.popup_auto').addClass('is_loading');
            if (this.files[0]) {
                var img = new Image();
                img.src = window.URL.createObjectURL( this.files[0] );
                img.onload = function() {
                    if(this.width<550){
                        $('.uploading_images_errorMsg').html('<p>{{Lang::get("message.You can not upload image less than 550px width.")}}</p>');
                        $('.uploading_images_errorMsg').show();
                        $('.add_images_popup').find('.popup_auto').removeClass('is_loading');
                        return;
                        event.preventDefault();
                    }else{
                       
                        var formData = new FormData(document.getElementById('add_images_form'));
                        $.ajax({
                                url: $('#add_images_form').attr('action'),
                                type: "POST",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function (msg) {
                                    $('.add_images_popup').find('.popup_auto').removeClass('is_loading');
                                    var response = JSON.parse(msg);
                                    if(response.status==true){
                                        var response_image = response.data;
                                        create_ad_item_photos.push(response_image.id);
                                        var image_html = '<li><div class="uploading_image_box image_uploaded_done"> <span><i class="uploading_image_close" onclick="delete_ad_image(this, '+response_image.id+')"></i><img src="'+response_image.full_image+'" alt="#" onerror="this.onerror=null;this.src="{{asset('public/uploads/no_user_image.png')}}";"></span><div class="image_uploading_progress active"><div class="image_uploading_progress_bar active" style="width:100%"></div></div></div></li>';
                                        $('.add_images_popup').find('ul').append(image_html);
                                    }else{
                                        $('.uploading_images_errorMsg').html('<p>'+response.message+'</p>');
                                        $('.uploading_images_errorMsg').show();
                                    }
                                
                                
                                }
                        });
                    }
                };
              
            }
            
        });
        $('.itemPromo_enable_switch_check').change(function(){
            set_promotion_label();
        });
    });

    //go to store page after success creation
    function goToStorePage(){
        const queryString = window.location.search;
        let url = APP_URL + '/ad/' + queryString;
        let href = new URL(url);

        href.searchParams.set('selling', 1);
        href.searchParams.set('type', create_ad_item_type);
        console.log(href);
        
        location.href = href.toString();
    }
    //create new ad
    function create_new_ad(){
        $('.item_promotion_popup').find('.popup_auto').addClass('is_loading');
        $('.item_promotion_popup').find('.item_promotion_error').remove();
        var ad_array;

        if(create_ad_item_type=='item'){
            ad_array = {
                item_type: create_ad_item_type,
                name: create_ad_name,
                description: create_ad_description,
                category: create_ad_category,
                location: create_ad_location,
                latitude: create_ad_latitude,
                longitude: create_ad_longitude,
                is_promotion: create_ad_is_promotion,
                item_photos: create_ad_item_photos,
                condition: create_ad_condition,
                make: create_ad_make,
                model: create_ad_model,
                max_price: create_ad_max_price,
                year: create_ad_year,
                interior_color: create_ad_interior_color,
                exterior_color: create_ad_exterior_color,
                transmission: create_ad_transmission,
                no_of_cylinders: create_ad_no_of_cylinders,
                type: create_ad_type
            };
        }else if(create_ad_item_type=='request'){
                ad_array = {
                item_type: create_ad_item_type,
                name: create_ad_name,
                description: create_ad_description,
                category: create_ad_category,
                location: create_ad_location,
                latitude: create_ad_latitude,
                longitude: create_ad_longitude,
                is_promotion: create_ad_is_promotion,
                item_photos: create_ad_item_photos,
                price_from:create_ad_price_from,
                price_to:create_ad_price_to
            };
        }else{
                ad_array = {
                item_type: create_ad_item_type,
                name: create_ad_name,
                description: create_ad_description,
                category: create_ad_category,
                location: create_ad_location,
                latitude: create_ad_latitude,
                longitude: create_ad_longitude,
                is_promotion: create_ad_is_promotion,
                item_photos: create_ad_item_photos
            };
        }
    
       console.log(ad_array);
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/create-ad') }}",
            type: 'POST',
            data: ad_array,
           
        }).done(function (result) {
            $('.item_promotion_popup').find('.popup_auto').removeClass('is_loading');
            var response = JSON.parse(result);
            console.log(result);
            console.log(response);
            console.log(response.status);
            if(response.status==true){
                $(".all_popup").hide();
                var result_data = response.data;
                if(create_ad_item_type=='item' || create_ad_item_type=='request'){ 
                    
                    $(".item_added_popup").find('.deal_list_img a').html("<img src='"+result_data.photos[0].full_image+"' alt='#' onerror='this.onerror=null;this.src='{{asset('public/uploads/no_user_image.png')}}';'>");
                    $(".item_added_popup").find('.deal_list_detail').find('h3').html('<a href="{{url("/ad-detail")}}?ad-key='+result_data.item_sef+'">'+result_data.item_name+'</a>');
                    $(".item_added_popup").find('.deal_list_auther').html('<span>'+result_data.user.user_name+'</span>');
                    
                    
                    
                    if(create_ad_item_type=='item'){
                        if(result_data.item_to_price>0){
                            $(".item_added_popup").find('.deal_list_price').html('<strong>'+result_data.user.language.currency_symbol+' '+result_data.item_to_price+'</strong><div class="deal_list_time">'+result_data.promotion_end_date_format+'</div>');
                        }else{
                            $(".item_added_popup").find('.deal_list_price').html('<strong>N/A</strong><div class="deal_list_time">'+result_data.promotion_end_date_format+'</div>');
                        }
                        $(".item_added_popup").find('.itemAdded_heading').html("<h2>{{Lang::get('label.Item Added!')}}</h2><p>"+response.message+"</p>");
                    }else{
                        $(".item_added_popup").find('.deal_list_price').html('<strong>'+result_data.user.language.currency_symbol+' '+result_data.item_from_price+'~'+result_data.user.language.currency_symbol+' '+result_data.item_to_price+'</strong><div class="deal_list_time">'+result_data.promotion_end_date_format+'</div>');
                        
                        $(".item_added_popup").find('.itemAdded_heading').html("<h2>{{Lang::get('label.Request Added!')}}</h2><p>"+response.message+"</p>");
                    }
                    $(".item_added_popup").show();
                }else{
                    $(".service_added_popup").find(".serviceAdded_box").find("h3").text(result_data.item_name);
                    $(".service_added_popup").find(".serviceAdded_box").find("p").text(result_data.item_description.slice(0, 200) + (result_data.item_description.length > 200 ? "..." : ""));
                    $(".service_added_popup").find(".itemAdded_heading").html("<h2>{{Lang::get('label.Service Added!')}}</h2><p>"+response.message+"</p>");
                    $(".service_added_popup").show();
                }
                $("html, body").addClass("popup_hidden");
            }else{
                error_stroke = "<div class='item_promotion_error' style='text-align:center;padding-bottom:15px;'><em class='fieldError_text'>{{Lang::get('message.Please select category.')}}</em></div>";
                $('.item_promotion_popup').find('.itemPromo_enable_row').before(error_stroke);
                var offset_top =  $('.item_promotion_popup').find('.item_promotion_error').offset().top;
                $('.all_popup').animate({
                    scrollTop: offset_top
                }, 'smooth');
                return false;
            }
        });
    }
    //validation for title description category 
    function checkAdInfoValidation(class_name){
        var error_stroke = "";
        $(".formCell input, .formCell textarea, .selectbox_span").removeClass("error_stroke");
        $(".fieldError_text").remove();

        if(create_ad_category==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select category.')}}</em>";
            $('.'+class_name).find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find(".selectbox_span").closest(".formCell").append(error_stroke);
        }

        if($('.'+class_name).find("[name='ad_title']").val()==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter title.')}}</em>";
            $('.'+class_name).find("[name='ad_title']").addClass("error_stroke");
            $('.'+class_name).find("[name='ad_title']").closest(".formCell").append(error_stroke);
        }else{
            create_ad_name = $('.'+class_name).find("[name='ad_title']").val();
        }

        if($('.'+class_name).find("[name='ad_desc']").val()==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter description.')}}</em>";
            $('.'+class_name).find("[name='ad_desc']").addClass("error_stroke");
            $('.'+class_name).find("[name='ad_desc']").closest(".formCell").append(error_stroke);
        }else{
            create_ad_description = $('.'+class_name).find("[name='ad_desc']").val();
        }

        if($('.'+class_name).find("[name='ad_loc']").val()==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter preferred location.')}}</em>";
            $('.'+class_name).find("[name='ad_loc']").addClass("error_stroke");
            $('.'+class_name).find("[name='ad_loc']").closest(".formCell").append(error_stroke);
        }else{
            create_ad_location = $('.'+class_name).find("[name='ad_loc']").val();
            create_ad_latitude = $('.'+class_name).find("[name='ad_latitude']").val();
            create_ad_longitude = $('.'+class_name).find("[name='ad_longitude']").val();
        }

        if(class_name=='request_item_info_popup'){
            if($('.'+class_name).find("[name='ad_price_from']").val()==''){
                error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter value of price from.')}}</em>";
                $('.'+class_name).find("[name='ad_price_from']").addClass("error_stroke");
                $('.'+class_name).find("[name='ad_price_from']").closest(".formCell").append(error_stroke);
            }else{
                create_ad_price_from = $('.'+class_name).find("[name='ad_price_from']").val();
            }

            if($('.'+class_name).find("[name='ad_price_to']").val()==''){
                error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter value of price to.')}}</em>";
                $('.'+class_name).find("[name='ad_price_to']").addClass("error_stroke");
                $('.'+class_name).find("[name='ad_price_to']").closest(".formCell").append(error_stroke);
            }else{
                create_ad_price_to = $('.'+class_name).find("[name='ad_price_to']").val();
            }
        }
        if (error_stroke !== "") {
            var offset_top =  $('.'+class_name).find('.error_stroke:first').offset().top;
            $('.all_popup').animate({
                
                scrollTop: offset_top
            }, 'smooth');
            return false;
        } else {
            $(".formCell input, .formCell textarea, .selectbox_span").removeClass("error_stroke");
            $(".fieldError_text").remove();
            return true;
        }
    }

    //validation for meta data  
    function checkAdMetaDataValidation(class_name){
        var error_stroke = "";
        $(".formCell input, .formCell textarea, .selectbox_span").removeClass("error_stroke");
        $(".fieldError_text").remove();

        if(create_ad_type==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select type.')}}</em>";
            $('.'+class_name).find("#dropdown_type").parents(".selectbox").find('.selectbox_span').addClass("error_stroke");
            $('.'+class_name).find("#dropdown_type").parents(".formCell").append(error_stroke);
        }

        if(create_ad_condition==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select condition.')}}</em>";
            $('.'+class_name).find("#dropdown_condition").parents(".selectbox").find('.selectbox_span').addClass("error_stroke");
            $('.'+class_name).find("#dropdown_condition").parents(".formCell").append(error_stroke);
        }

        if(create_ad_make==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select make.')}}</em>";
            $('.'+class_name).find("#dropdown_make").parents(".selectbox").find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find("#dropdown_make").parents(".formCell").append(error_stroke);
        }

        if(create_ad_model==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select model.')}}</em>";
            $('.'+class_name).find("#dropdown_model").parents(".selectbox").find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find("#dropdown_model").parents(".formCell").append(error_stroke);
        }

        if(create_ad_interior_color==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select interior color.')}}</em>";
            $('.'+class_name).find("#dropdown_interior_color").parents(".selectbox").find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find("#dropdown_interior_color").parents(".formCell").append(error_stroke);
        }

        if(create_ad_exterior_color==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select exterior color.')}}</em>";
            $('.'+class_name).find("#dropdown_exterior_color").parents(".selectbox").find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find("#dropdown_exterior_color").parents(".formCell").append(error_stroke);
        }

        if(create_ad_transmission==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select transmission.')}}</em>";
            $('.'+class_name).find("#dropdown_transmission").parents(".selectbox").find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find("#dropdown_transmission").parents(".formCell").append(error_stroke);
        }

        if(create_ad_no_of_cylinders==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please select number of cylinders.')}}</em>";
            $('.'+class_name).find("#dropdown_no_cylinders").parents(".selectbox").find(".selectbox_span").addClass("error_stroke");
            $('.'+class_name).find("#dropdown_no_cylinders").parents(".formCell").append(error_stroke);
        }

        if($('.'+class_name).find("[name='ad_year']").val()==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter year.')}}</em>";
            $('.'+class_name).find("[name='ad_year']").addClass("error_stroke");
            $('.'+class_name).find("[name='ad_year']").closest(".formCell").append(error_stroke);
        }else{
            create_ad_year = $('.'+class_name).find("[name='ad_year']").val();
        }
    
        if($('.'+class_name).find("[name='ad_max_price']").val()==''){
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter value of maximum price.')}}</em>";
            $('.'+class_name).find("[name='ad_max_price']").addClass("error_stroke");
            $('.'+class_name).find("[name='ad_max_price']").closest(".formCell").append(error_stroke);
        }else{
            create_ad_max_price = $('.'+class_name).find("[name='ad_max_price']").val();
        }

        if (error_stroke !== "") {
            var offset_top =  $('.'+class_name).find('.error_stroke:first').offset().top;
            $('.all_popup').animate({
                
                scrollTop: offset_top
            }, 'smooth');
            return false;
        } else {
            $(".formCell input, .formCell textarea, .selectbox_span").removeClass("error_stroke");
            $(".fieldError_text").remove();
            return true;
        }
    }

    //calling when getting categories for dropdown
    function get_promotion_settings(){
        $('.item_promotion_popup').find('.popup_auto').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/get-ajax-settings') }}",
            type: 'GET',
            data: {},
        }).done(function (result) {
            settings_params = result;
            set_promotion_label();
            $('.item_promotion_popup').find('.popup_auto').removeClass('is_loading');
        });
    }
     //calling when setting design of promotion
     function set_promotion_label(){
        if($('.item_promotion_popup').find('.itemPromo_enable_switch').hasClass('active')){
            create_ad_is_promotion =1;
            $('.promotion_popup_text').html("{{Lang::get('label.Promotion Days')}}<strong> "+settings_params.promotion_days+"  {{Lang::get('label.Days')}}</strong>");
            if(settings_params.remaining_ads>0){
                
                $('.userBlnce_txt').find('strong').text("{{Lang::get('label.Your Promotion ads left')}}");
                if(settings_params.remaining_ads>1){
                    $('.userBlnce_txt').find('small').text(settings_params.remaining_ads+" {{Lang::get('label.ads left')}}");
                }else{
                    $('.userBlnce_txt').find('small').text(settings_params.remaining_ads+" {{Lang::get('label.ad left')}}");
                }
                
                $('.itemPromo_useBlnce_main').removeClass('itemPromo_useBlnce_check');
                $('.itemPromo_useBlnce_main').addClass('itemPromo_promo_check');
                
                $('.itemPromo_price').find('small').text('');
                $('.itemPromo_price').find('h2').html('');
                
            }else{
                $('.userBlnce_txt').find('strong').text("{{Lang::get('label.Your Balance')}}");
                if(parseInt(settings_params.remaining_balance)>0){
                    $('.userBlnce_txt').find('small').text("{{@session()->get('currency')}}"+' '+settings_params.remaining_balance);
                }else{
                    $('.userBlnce_txt').find('small').text("N/A");
                }
                $('.itemPromo_useBlnce_main').removeClass('itemPromo_promo_check');
                $('.itemPromo_useBlnce_main').addClass('itemPromo_useBlnce_check');

                $('.itemPromo_price').find('small').text('{{Lang::get("label.Promotion Costs")}}');
                if(settings_params.promoted_ad_cost>0){
                    $('.itemPromo_price').find('h2').html('<span>{{@session()->get("currency")}}</span> '+settings_params.promoted_ad_cost);
                }else{
                    $('.itemPromo_price').find('h2').html('{{Lang::get("label.Free")}}');
                }
                
            }
            $('.promotion_popup_text_end_date').text("{{Lang::get('label.Your promotion will expire on')}}"+' '+settings_params.promotion_end_date);
        }else{
            create_ad_is_promotion = 0;
            $('.itemPromo_price').find('small').text('{{Lang::get("label.Listing Costs")}}');
            if(settings_params.ad_cost>0){
                $('.itemPromo_price').find('h2').html('<span>{{@session()->get("currency")}}</span> '+settings_params.ad_cost);
            }else{
                $('.itemPromo_price').find('h2').html('{{Lang::get("label.Free")}}');
            }
            if(settings_params.ad_days>0){
                $('.promotion_popup_text').html("{{Lang::get('label.Listing Days')}}<strong> "+settings_params.ad_days+" {{Lang::get('label.Days')}}</strong>");
            }else{
                $('.promotion_popup_text').html("{{Lang::get('label.Listing Days')}}<strong> N/A</strong>");
            }
            
            $('.userBlnce_txt').find('strong').text("{{Lang::get('label.Your Balance')}}");
            if(parseInt(settings_params.remaining_balance)>0){
                $('.userBlnce_txt').find('small').text("{{@session()->get('currency')}}"+' '+settings_params.remaining_balance);
            }else{
               $('.userBlnce_txt').find('small').text("N/A");
            }
            $('.itemPromo_useBlnce_main').removeClass('itemPromo_promo_check');
            $('.itemPromo_useBlnce_main').addClass('itemPromo_useBlnce_check');

            $('.promotion_popup_text_end_date').text("{{Lang::get('label.Your listing will expire on')}}"+' '+settings_params.listing_end_date);
        
        }
       //if()
    }
    //calling for map auto places address
    function initMap(class_name) {
    
        var input = document.getElementById(class_name+'_preferred_location');
        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
            myLatLng = {lat: place.geometry.location.lat(), lng: place.geometry.location.lng()};
           
            $('#'+class_name+'_latitude').val(place.geometry.location.lat());
            $('#'+class_name+'_longitude').val(place.geometry.location.lng());


            create_ad_location = $('#'+class_name+'_preferred_location').val();
            create_ad_latitude = $('#'+class_name+'_latitude').val();
            create_ad_longitude = $('#'+class_name+'_longitude').val();

            create_map(myLatLng,class_name);
        });

    }
    //calling for map marker drag and change location
    function create_map(myLatLng,class_name) {
        var map = new google.maps.Map(document.getElementById(class_name+'_map'), {
            center: myLatLng,
            zoom: 13
        });
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '',
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function(){
            var latLng = marker.getPosition();
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latLng }, function (results) {
                if (results && results.length > 0) {
                    
                    $('#'+class_name+'_latitude').val(latLng.lat());
                    $('#'+class_name+'_longitude').val(latLng.lng());
                    $('#'+class_name+'_preferred_location').val(results[0].formatted_address);

                    create_ad_location =  $('#'+class_name+'_preferred_location').val();
                    create_ad_latitude = $('#'+class_name+'_latitude').val();
                    create_ad_longitude = $('#'+class_name+'_longitude').val();
                   
                }
            });
        });
    }
    //calling when getting categories for dropdown
    function get_category_popup_dropdown(class_name){
        $('.'+class_name).find('.popup_auto').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/get-ajax-ad-category') }}",
            type: 'GET',
            data: {},
        }).done(function (result) {
            $('.'+class_name).find('.dropdown_category').html(result.data);
            $('.'+class_name).find('.popup_auto').removeClass('is_loading');
        });
    }
    // calling when user change category from create ad popup
    function change_dropdown_category(d){
        create_ad_category = $(d).find(":selected").attr('data-value');   
    }

    // calling when user change item_type from create ad popup
    function change_dropdown_item_type(d){
        
       create_ad_type = $(d).find(":selected").attr('data-value');   
    }

    // calling when user change item condition from create ad popup
    function change_dropdown_item_condition(d){
        create_ad_condition = $(d).find(":selected").attr('data-value');     
    }

    // calling when user change makes from create ad popup
    function change_dropdown_item_make(d){
        create_ad_make = $(d).find(":selected").attr('data-value'); 
        $(d).parents('.formRow').find('#dropdown_model').html('<option data-value="" >{{Lang::get("label.Model")}}</option>');
        $(d).parents('.formRow').find('.dropdown_model_span').text('{{Lang::get("label.Model")}}');
        var model_html = '';
        var models=$(d).find(":selected").attr('data-meta-data');
        if(models){
            models_array = JSON.parse(models);
            model_html+='<option data-value="" >{{Lang::get("label.Model")}}</option>';
           for(var i=0; i<models_array.length; i++){
                model_html+="<option data-value='"+models_array[i].id+"' >"+models_array[i].model_name+"</option>";
           }
        }
        $(d).parents('.formRow').find('#dropdown_model').html(model_html);
    }

    // calling when user change model from create ad popup
    function change_dropdown_item_model(d){
        create_ad_model = $(d).find(":selected").attr('data-value');   
    }

    // calling when user change interior color from create ad popup
    function change_dropdown_item_interior_color(d){
        create_ad_interior_color = $(d).find(":selected").attr('data-value'); 
    }

    // calling when user change exterior color from create ad popup
    function change_dropdown_item_exterior_color(d){
        create_ad_exterior_color = $(d).find(":selected").attr('data-value');   
    }

    // calling when user change  transmission from create ad popup
    function change_dropdown_item_transmission(d){
        create_ad_transmission = $(d).find(":selected").attr('data-value');    
    }

    // calling when user change no_cylinders from create ad popup
    function change_dropdown_item_no_cylinders(d){
        create_ad_no_of_cylinders = $(d).find(":selected").attr('data-value');  
    }

    //calling when getting all dropdown item meta data 
    function get_all_meta_item_data(){
        $('.item_info_popup').find('.popup_auto').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/get-ajax-ad-metadata') }}",
            type: 'GET',
            data: {},
        }).done(function (result) {
            console.log(result);
            $('.item_info_popup').find('.formParent').html(result.data);
            $('.item_info_popup').find('.popup_auto').removeClass('is_loading');
        });
    }
    //calling when need to delete uploaded temporary ad image
    function delete_ad_image(d, id){
        $('.add_images_popup').find('.popup_auto').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/remove-image') }}",
            type: 'POST',
            data: {'image_id':id, 'image_key': 'temp'},
        }).done(function (result) {
            const index = create_ad_item_photos.indexOf(id);
            if (index > -1) {
                create_ad_item_photos.splice(index, 1);
            }
            $('.add_images_popup').find('.popup_auto').removeClass('is_loading');
            $(d).parents('li').remove();
        });
    }
    // calling when language popup open to get language list
    function get_languages(){
        $('.language_popup').find('.lang_check_main').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/get-langauge') }}",
            type: 'GET',
            data: {},
        }).done(function (result) {
           $('.language_popup').find('.lang_check_main').removeClass('is_loading');
           $('#ajax_languages').html(result.data);
        });
    }
    // calling when user needs to change language
    function change_language(d){
        $(d).addClass('disabled_loader');
        var selected_langauge = $('#ajax_languages').find('.pick_service_box.active').find('input').val();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/change-language') }}",
            type: 'POST',
            data: {'language':selected_langauge},
        }).done(function (result) {
            $(d).removeClass('disabled_loader');
            window.location.reload();
        });
    } 

    // calling when filter popup open to get categories
    function get_categories(){
        $('.filter_categories').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/get-category') }}",
            type: 'GET',
            data: {},
        }).done(function (result) {
           $('.filter_categories').removeClass('is_loading');
           $('.filter_categories').find('#ajax_categories').html(result.data);

           make_category_active();
        });
    }
    
    // calling when user change sort type from sort popup and click on button sort result
    function sort_result(d){
        var getSelectedValue = document.querySelector( 'input[name="sort_radio"]:checked'); 
        home_ad_sort_by = getSelectedValue.value;
        const queryString = window.location.search;
        let url = '';
        if (document.URL.indexOf('/ad') != -1) {
            url = APP_URL + '/ad/' + queryString;
        }else{
            url = APP_URL + '/home/' + queryString;
        }
        let href = new URL(url);
        href.searchParams.set('sort', home_ad_sort_by);
        location.href = href.toString();
    }

    // calling when user change category from filter popup but still not click filter result button
    function change_category(d){
        $('.filter_cat_btn').removeClass('active'); 
        home_ad_category = $(d).attr('data-value'); 
        $(d).addClass('active');       
    }

    

    // calling when user click on filter button from filter popup
    function filter_result(d){

        const queryString = window.location.search;
        let url = '';
        if (document.URL.indexOf('/ad') != -1) {
            url = APP_URL + '/ad/' + queryString;
        }else{
            url = APP_URL + '/home/' + queryString;
        }

        let href = new URL(url);

        home_ad_search_key = $('.filter_search_row').find('#search_key').val();

        if(home_ad_search_key!=''){
            href.searchParams.set('key', home_ad_search_key);
        }else{
            //to delete key from url
            var url_params = new URL(url);
            url_params.searchParams.delete('key');
            url = url_params.href;
            href = new URL(url);
        }
       
        

        href.searchParams.set('category', home_ad_category);

        if(is_range_move==1){
            href.searchParams.set('from', home_ad_from_price);

            href.searchParams.set('to', home_ad_to_price);
        }

        location.href = href.toString();
    }

    $(document).ready(function(e) {
    
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

          // making active class on ready  between  selling item and buying item 
          home_ad_is_selling = urlParams.get('selling');
         if(home_ad_is_selling==1){
          $('.filter_sellingBuy_itemSell').addClass('active');
         }else{
          $('.filter_sellingBuy_itemBuy').addClass('active');
         }

          // making active class on ready  between  item, request and service 
          home_ad_type = urlParams.get('type');         
         if(home_ad_type=='request'){
              $('.filter_serviceItems_link.request').addClass('active');
              $('.deal_listing_main').show();
              $('.services_listing_main').hide();
         }else if(home_ad_type=='service'){
              $('.filter_serviceItems_link.service').addClass('active');
              $('.deal_listing_main').hide();
              $('.services_listing_main').show();
         }else{
              home_ad_type = 'item';
              $('.filter_serviceItems_link.item').addClass('active');
              $('.deal_listing_main').show();
              $('.services_listing_main').hide();
         }
        // making checked radio button on ready  between  sort values popup 
        if(urlParams.get('sort')){
            home_ad_sort_by = urlParams.get('sort'); 
        }
       
        $("input[name=sort_radio][value=" + home_ad_sort_by + "]").attr('checked', 'checked');
    

        // Get category filter 
        if(urlParams.get('category')){
            home_ad_category = urlParams.get('category'); 
        }


         // Get search key filter 
         if(urlParams.get('key')){
            home_ad_search_key = urlParams.get('key'); 
            $('.filter_search_row').find('#search_key').val(home_ad_search_key);
        }
       

        // Get from price AND TO PRICE filter 
        if(urlParams.get('from') || urlParams.get('TO')){
            is_range_move = 1;
            home_ad_from_price = urlParams.get('from'); 
            home_ad_to_price = urlParams.get('to'); 

            // 2. Save instance to variable
            let my_range = $(".side_priceRange_slider").data("ionRangeSlider");
    
            // 3. Update range slider content (this will change handles positions)
            my_range.update({
                from: home_ad_from_price,
                to: home_ad_to_price
            });
        }
        let current_url = window.location.href;
        
        if (document.URL.indexOf('/home') != -1 || APP_URL+'/'==current_url || document.URL.indexOf('/ad') != -1) {
            if(document.URL.indexOf('/ad') != -1){
                filter_ajax_ads(0, 'ad');
            }else{
                filter_ajax_ads(0, 'home');
            }
        }
    });

    // calling when categories are loaded in filter popup then make active class on selected category
    function make_category_active(){
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        if(urlParams.get('category')){
            home_ad_category = urlParams.get('category');   
        }
        if(urlParams.get('type')=='service'){
            $('.side_filter_title_text').hide();
            $('.side_priceRange_row').hide();
        }else{
            $('.side_filter_title_text').show();
            $('.side_priceRange_row').show();
        }
        $(".filter_cat_btn").removeClass('active');
        $(".filter_cat_btn[data-value=" + home_ad_category + "]").addClass('active');
    }

    // calling for all apllying filter and get ads result 
    function filter_ajax_ads(page, page_type) {
    
        if(home_ad_type=='service'){
            $("#filter_ajax_service_ad").parent('.services_listing_main ').addClass('is_loading');
        }else{
            $("#filter_ajax_ads").parent('.deal_listing_main ').addClass('is_loading');
        }
        if(page==0){
            home_ad_page = 1;
        }else{
            home_ad_page = home_ad_page+1;
        }
    
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/filter-ajax-ads') }}",
            type: 'POST',
            data: {'page_type':page_type, 'page_no' : home_ad_page, 'is_selling': home_ad_is_selling, 'type' :home_ad_type, 'sort': home_ad_sort_by, 'category': home_ad_category, 'key':home_ad_search_key , 'from' : home_ad_from_price , 'to': home_ad_to_price, 'is_range_move':is_range_move},
        }).done(function (result) {
            console.log(result);
            if(home_ad_type=='service'){
                $("#filter_ajax_service_ad").parent('.services_listing_main ').removeClass('is_loading');

                if($("#filter_ajax_service_ad").find('li.deal_li').hasClass('no_record_div')){
                home_ad_empty_rec = true;
                }
                if(home_ad_empty_rec==true){

                }else{
                $("#filter_ajax_service_ad").append(result.data);
                    call_slick_function();
                }
            }else{
                $("#filter_ajax_ads").parent('.deal_listing_main ').removeClass('is_loading');

                if($("#filter_ajax_ads").find('li.deal_li').hasClass('no_record_div')){
                home_ad_empty_rec = true;
                }
                if(home_ad_empty_rec==true){

                }else{
                $("#filter_ajax_ads").append(result.data);
                }
            }
        });
            
    }

    // calling when services are listed to enable slider
    function call_slick_function(){
        var slider = $(".services_list_slider");
        $(slider).slick({
            dots: true,
            infinite: true,
            speed: 300,
            slidesToShow: 1,
            adaptiveHeight: true,
            //speed: 500,
            //fade: true,
            //cssEase: 'linear',
            arrows: false
        });
    }

    //add favorite
    function add_favorite(d, id){
        $('.item_promotion_error').remove();
        if(home_ad_type=='service'){
            $("#filter_ajax_service_ad").parent('.services_listing_main ').addClass('is_loading');
        }else{
            $("#filter_ajax_ads").parent('.deal_listing_main ').addClass('is_loading');
        }
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/like-unlike') }}",
            type: 'POST',
            data: {'item_id':id},
        }).done(function (result) {
            var response = JSON.parse(result);
          
            if(home_ad_type=='service'){
                $("#filter_ajax_service_ad").parent('.services_listing_main ').removeClass('is_loading');
            }else{
                $("#filter_ajax_ads").parent('.deal_listing_main ').removeClass('is_loading');
            }
            if(response.status==true){
                if($(d).hasClass('active')){
                    $(d).removeClass('active');
                }else{
                    $(d).addClass('active');
                }
            }else{
                error_stroke = "<div class='item_promotion_error' style='text-align:center;padding-bottom:30px;'><em class='fieldError_text'>"+response.message+"</em></div>";
                if(home_ad_type=='service'){
                    $("#filter_ajax_service_ad").before(error_stroke);
                }else{
                    $("#filter_ajax_ads").before(error_stroke);
                }
               
                $('html, body').animate({
                    scrollTop: $('.active_deals_content').find('.item_promotion_error').offset().top-100
                }, 'smooth');
                //return false;
            }
        });
            
    }
   
</script>
</html>