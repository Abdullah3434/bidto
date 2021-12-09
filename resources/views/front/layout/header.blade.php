    <div class="header_main">
      <div class="menuIcon"> <span></span> <span></span> <span></span> <span></span> </div>
      <div class="header_inner">
        <div class="logo"> 
          <a href="{{url('/')}}">
            <figure>
              <img src="{{asset('public/front_assets/images/logo.svg')}}" alt="#.">
            </figure>
          </a> 
        </div>
        <div class="header_right">
          <div class="header_search">
            <div class="header_srch_field">
              <input type="text" placeholder="{{Lang::get('label.Search')}}">
            </div>
          </div>
          <div class="header_uer_info_sec">
            <ul>
              <li class="header_uer_info_li header_searchMob_li">
                <div class="header_searchMob_div">
                  <a href="javascript:void(0)" class="header_searchMob_icon"></a>
                </div>
              </li>
              <li class="header_uer_info_li">
                <div class="header_settings">
                  <a href="javascript:void(0)" class="header_settings_icon"></a>
                </div>
              </li>
              @if(session()->get('login_token'))
                <li class="header_uer_info_li">
                  <div class="header_notify">
                    <a  href="javascript:void(0)" class="header_notify_bell">
                      @if(@session()->get('total_unread_notifications')>0)
                        <i class="header_notify_status"></i>
                      @endif
                    </a>
                    <div class="notify_popup notify_popup_show">
                      <div class="notifyPop_inner">
                        <div class="notifyPop_header"> 
                          <strong>{{Lang::get("label.Notification")}}
                            <a href="javascript:void(0)">{{Lang::get("label.Remove all")}}</a>
                          </strong> 
                        </div>
                        <div class="notifyPop_content">
                          <div class="notify_popup_tabs">
                            <div class="notify_popup_tabs_title">
                              <ul>
                                <li>
                                  <a class="filter_sellingBuy_btn notify_popup_tab_buyer active" href="javascript:void(0)">{{Lang::get("label.Buyer")}}</a>
                                </li>
                                <li>
                                  <a class="filter_sellingBuy_btn notify_popup_tab_seller" href="javascript:void(0)">{{Lang::get("label.Seller")}}</a>
                                </li>
                              </ul>
                            </div>
                            <div class="notify_popup_tabs_content">
                              <div class="notify_popup_tabs_show notify_popup_tab_buyer">
                                <div class="notifyPop_rowGroup_row">
                                  <div class="notifyPop_rowGroup_title"> 
                                    <strong>Today</strong> 
                                    <span>2 Items</span> 
                                  </div>
                                  <ul class="notifyPop_rowGroup">
                                    <li>
                                      <div class="notifyPop_list_box">
                                        <div class="notify_dotted_menu"> 
                                          <span class="notify_dotted_icon"></span>
                                          <div class="notify_dotted_dropdown">
                                            <p>
                                              <a class="notify_dotted_remove" href="javascript:void(0)">{{Lang::get("label.Remove")}}</a>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="notifyPop_list_img"> 
                                          <span>
                                            <img src="{{asset('public/front_assets/images/deals_img3.png')}}" alt="#">
                                          </span> 
                                        </div>
                                        <div class="notifyPop_text">
                                          <p>Khalid has made a higher bid on <strong>mazda 3</strong> today!</p>
                                          <small>3 hours ago</small> 
                                        </div>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="notifyPop_list_box">
                                        <div class="notify_dotted_menu"> 
                                          <span class="notify_dotted_icon"></span>
                                          <div class="notify_dotted_dropdown">
                                            <p>
                                              <a class="notify_dotted_remove" href="javascript:void(0)">{{Lang::get("label.Remove")}}</a>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="notifyPop_list_img"> 
                                          <span>
                                            <img src="{{asset('public/front_assets/images/deals_img3.png')}}" alt="#">
                                          </span> 
                                        </div>
                                        <div class="notifyPop_text">
                                          <p>Khalid has made a higher bid on <strong>mazda 3</strong> today!</p>
                                          <small>3 hours ago</small> 
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                                <div class="notifyPop_rowGroup_row">
                                  <div class="notifyPop_rowGroup_title"> 
                                    <strong>Yesterday</strong> 
                                    <span>4 Items</span> 
                                  </div>
                                  <ul class="notifyPop_rowGroup">
                                    <li>
                                      <div class="notifyPop_list_box">
                                        <div class="notify_dotted_menu"> 
                                          <span class="notify_dotted_icon"></span>
                                          <div class="notify_dotted_dropdown">
                                            <p>
                                              <a class="notify_dotted_remove" href="javascript:void(0)">{{Lang::get("label.Remove")}}</a>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="notifyPop_list_img"> 
                                          <span>
                                            <img src="{{asset('public/front_assets/images/deals_img3.png')}}" alt="#">
                                          </span> 
                                        </div>
                                        <div class="notifyPop_text">
                                          <p>Khalid has made a higher bid on <strong>mazda 3</strong> today!</p>
                                          <small>3 hours ago</small> 
                                        </div>
                                      </div>
                                    </li>
                                    <li>
                                      <div class="notifyPop_list_box">
                                        <div class="notify_dotted_menu"> 
                                          <span class="notify_dotted_icon"></span>
                                          <div class="notify_dotted_dropdown">
                                            <p>
                                              <a class="notify_dotted_remove" href="javascript:void(0)">{{Lang::get("label.Remove")}}</a>
                                            </p>
                                          </div>
                                        </div>
                                        <div class="notifyPop_list_img"> 
                                          <span>
                                            <img src="{{asset('public/front_assets/images/deals_img3.png')}}" alt="#">
                                          </span> 
                                        </div>
                                        <div class="notifyPop_text">
                                          <p>Khalid has made a higher bid on <strong>mazda 3</strong> today!</p>
                                          <small>3 hours ago</small> 
                                        </div>
                                      </div>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="header_uer_info_li header_user_info_li">
                  <div class="user_info_top">
                    <div class="header_user_info_text"> 
                      <strong>{{ucfirst(@session()->get('loginned_user')->user_name)}}</strong> 
                      <span>
                        <a class="header_editPro_link" href="javascript:void(0)">{{Lang::get("label.Edit Profile")}}</a>
                      </span> 
                    </div>
                    <a class="header_user_avatar" href="javascript:void(0)">
                      <img src="{{@session()->get('loginned_user')->thumb_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_user_image.png')}}';">
                      <i class="header_avatar_setting_icon"></i>
                    </a> 
                  </div>
                </li>
              @endif
            </ul>
          </div>
        </div>
      </div>
    </div>