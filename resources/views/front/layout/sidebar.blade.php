    <div class="left_bar_inner">
      <div class="user_info_mob">
        <div class="user_info_top ">
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
      </div>
      <div class="menuMain">
        <div class="menu_clos">x</div>
        <ul class="lb_menuTop_list">
          <li>
            <a class="lb_home {{isActiveRoute('/') }} {{isActiveRoute('home')}}" href="{{url('/')}}">{{Lang::get("label.Home")}}</a>
          </li>
          <li>
            <a class="lb_categories {{isActiveRoute('category')}}" href="{{url('/category')}}">{{Lang::get("label.Categories")}}</a> 
          </li>
          <li>
            <a class="lb_active_deals {{isActiveRoute('ad')}} {{isActiveRoute('ad-detail')}}" href="{{url('/ad')}}">{{Lang::get("label.Active Deals")}}</a> 
          </li>
          <li>
            <a class="lb_sponsorship" href="sponsors.html">{{Lang::get("label.Sponsorship")}}</a> 
          </li>
          <li>
            <a class="lb_Chat" href="chat.html">{{Lang::get("label.Chat")}}</a> 
          </li>
        </ul>
        <ul class="lb_menulogout_list">
          <li>
            <a class="lb_contactUs" href="contact_us.html">{{Lang::get("label.Contact Us")}}</a> 
          </li>
          <li>
            <a class="lb_signOut" href="{{url('/logout')}}">{{Lang::get("label.Sign out")}}</a> 
          </li>
        </ul>
      </div>
    </div>