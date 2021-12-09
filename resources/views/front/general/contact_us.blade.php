@extends('layouts.auth')

@section('content')
<div class="all_content_box">
  <div class="content_main">
    <div class="active_deals_main">
      <div class="autoContent">
        <div class="contact_us_main">
          <div class="contact_us_content">
            <div class="sponsors_title">
              <h2>{{Lang::get("label.Contact Us")}}</h2>
              <p>{{Lang::get("label.Check the list of our sponsors and let us know if you want to join them!")}}</p>
            </div>
            <div class="contact_form_main">
              <form name="formname" onsubmit="return contactus_form(this);" method="POST">
                <div class="formParent">
                  <div class="login_field_row">
                    <div class="login_form_field">
                      <input class="contactUs_title_fied" type="text" name="contactUs_title_fied" placeholder="{{Lang::get('label.Message Title')}}">
                    </div>
                  </div>
                  <div class="login_field_row">
                    <div class="login_form_field">
                      <textarea class="contactUs_message_area" type="text" name="contactUs_message_area" placeholder="{{Lang::get('label.Message Description')}}"></textarea>
                    </div>
                  </div>
                  <div class="contactUs_sendParent login_submit">
                    <input class="all_buttons light_green contactUs_sendmsg_btn btn_block" type="submit" value="{{Lang::get('label.Send Message')}}">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="contact_us_footer">
            <div class="contact_us_footer_left"> 
              <strong>{{Lang::get('label.Our Email')}}</strong> 
              <small>
                <a href="mailTo:Info@Bidto.com">Info@Bidto.com</a>
              </small> 
            </div>
            <div class="contact_us_footer_right">
              <ul>
                <li>
                  <a class="contact_social" href="javascript:void(0)">
                    <img src="{{asset('public/front_assets/images/google.svg')}}" alt="#">
                  </a>
                </li>
                <li>
                  <a class="contact_social" href="javascript:void(0)">
                    <img src="{{asset('public/front_assets/images/twitter.svg')}}" alt="#">
                  </a>
                </li>
                <li>
                  <a class="contact_social" href="javascript:void(0)">
                    <img src="{{asset('public/front_assets/images/facebook.svg')}}" alt="#">
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="all_popup small_popup contact_msg_sent_popup">
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
              <h2>{{Lang::get("label.Message Sent!")}}</h2>
              <p>{{Lang::get("label.Thanks for your interest in sponsoring  our app!")}} </p>
              <div class="formRow clearfix">
                <div class="formCell col12">
                  <a class="accountDleted_backBtn all_buttons btn_block lignt_green" href="javascript:void(0)">{{Lang::get("label.Back")}}</a>
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
@endsection
<script type="text/javascript">
  /*contact us from validation start here*/
  function contactus_form(theForm) {
    var mailStatus = 1;
    var error_stroke = "";
    $(".login_form_field input, .login_form_field textarea, .selectbox").removeClass("error_stroke");
    $(".fieldError_text").remove();


    if (theForm.contactUs_title_fied.value == "") {
      error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter Title Field')}}</em>";
      $(theForm).find("[name='contactUs_title_fied']").addClass("error_stroke");
      $(theForm).find("[name='contactUs_title_fied']").closest(".login_form_field").after(error_stroke);
    }

    if (theForm.contactUs_message_area.value == "") {
      error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter message')}}</em>";
      $(theForm).find("[name='contactUs_message_area']").addClass("error_stroke");
      $(theForm).find("[name='contactUs_message_area']").closest(".login_form_field").after(error_stroke);
    }

    if (error_stroke !== "") {
      return false;
    } else {
      $(".login_error").hide();
      $(".fieldError_text").remove();
      $(".contact_msg_sent_popup").show();
      $("html, body").addClass("popup_hidden");
      return false;
    }
  }

</script>
