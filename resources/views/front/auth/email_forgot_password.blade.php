@extends('front.layout.auth')

@section('content')
    <div class="login_form_box"> 
        <a class="otp_back_arrow" href="{{url('/login')}}"></a>
        <div class="login_form_section">
          <div class="login_title_text">
            <h2>{{Lang::get("label.Forgot Password")}}</h2>
            <p>{{Lang::get("label.Enter your registered email/phone number to receive a reset link for your password")}}</p>
          </div>
          <div class="forgot_recovery_type">
            <ul>
              <li>
                @php $email_active = "active"; 
                      if(@$phone==1){
                        $email_active = ""; 
                      }
                @endphp
                <a class="forgot_recovery_type_email {{$email_active}}" data-rel=".forgot_recovery_type_email_show" href="javascript:void(0)">
                  <i>
                    <img src="{{asset('public/front_assets/images/email_forgot.svg')}}" alt="#">
                  </i>{{Lang::get("label.Email Recovery")}}</a>
                </li>
              <li>
                @php $phone_active = ""; 
                        if(@$phone==1){
                          $phone_active = "active"; 
                        }
                  @endphp
                <a class="forgot_recovery_type_mob {{$phone_active}}" data-rel=".forgot_recovery_type_mob_show" href="javascript:void(0)">
                  <i>
                    <img src="{{asset('public/front_assets/images/sms_forgot.svg')}}" alt="#">
                  </i>{{Lang::get("label.Mobile Recovery")}}
                </a>
              </li>
            </ul>
          </div>

          @include('front.flash_message')

          <form name="formname" onsubmit="return forgotPw_save(this);" method="POST" action="{{url('/forgot-password')}}">
            {{ csrf_field() }}
            <input type="hidden" name="type" id="type" value="email">
            <div class="login_form">
                @php $email_block = "display:block;"; 
                      if(@$phone==1){
                        $email_block = "display:none;"; 
                      }
                @endphp
              <div class="forgot_pwType_show forgot_recovery_type_email_show" style="{{$email_block}}">
                <div class="login_field_row login_email_row"> 
                  <strong class="login_field_title login_email_icon">{{Lang::get("label.Email Address")}}</strong>
                  <div class="login_form_field">
                    <input type="text" name="email" placeholder="{{Lang::get('label.Email Address')}}">
                  </div>
                </div>
              </div>
              @php $phone_block = "display:none;"; 
                      if(@$phone==1){
                        $phone_block = "display:block;"; 
                      }
                @endphp
              <div class="forgot_pwType_show forgot_recovery_type_mob_show" style="{{$phone_block}}">
                <div class="login_field_row login_phone_row"> 
                  <strong class="login_field_title login_phone_icon">{{Lang::get("label.Mobile Number")}}</strong>
                  <div class="login_form_field">
                    <input type="text" name="phone" placeholder="{{Lang::get('label.Mobile Number')}}" onclick="phone_number_click(this)">
                  </div>
                </div>
              </div>
              <div class="login_field_row">
                <div class="login_submit forgot_resetPw_submit_parent">
                  <input class="all_buttons all_green forgot_resetPw_submit_btn" type="submit" value="{{Lang::get('label.Reset Password')}}">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
@endsection
@section('javascript')
<script type="text/javascript">
  function phone_number_click(obj){
		$(obj).mask('+000000000000');
}

    $(document).ready(function (e) {
      $(".login_form_field").each(function (index, element) {
        var fieldVal = $(this).find("input, textarea").val().length;
        if (fieldVal > 0) {
          $(this).addClass("isValue");
        } else {
          $(this).removeClass("isValue");
        }
      });
      $(".login_form_field input, .login_form_field textarea").focus(function (e) {
        $(this).parent().addClass("isFocus");
        var fieldVal = $(this).val().length;
        if (fieldVal < 1) {
          $(this).parent().removeClass("isValue");
        }
      });
      $(".login_form_field input, .login_form_field textarea").focusout(function (e) {
        $(this).parent().removeClass("isFocus");
        var fieldVal = $(this).val().length;
        if (fieldVal > 0) {
          $(this).parent().addClass("isValue");
        } else {
          $(this).parent().removeClass("isValue");
        }
      });

      $('.forgot_recovery_type ul li a').click(function(e) {
        var mailStatus = 1;
        var error_stroke = "";
        $(".login_form_field input, .login_form_field textarea, .selectbox").removeClass("error_stroke");
        $(".fieldError_text").remove();
        $('.alert p').html('');
      })
      ////////////////////////
      });
      function forgotPw_save(theForm){
        var mailStatus = 1;
        var error_stroke = "";
        $(".login_form_field input, .login_form_field textarea, .selectbox").removeClass("error_stroke");
        $(".fieldError_text").remove();
        $('.alert p').html('');
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if($('.forgot_recovery_type_email').hasClass('active')){
          $('#type').val('email');
          var totallane_user_email = $('.forgot_recovery_type_email_show').find("[name='email']");
          
          if ($('.forgot_recovery_type_email_show').find("[name='email']").val().length <= 0) {
            
            mailStatus = 1;
            
          }
          if (mailStatus === 1) {
            if ($('.forgot_recovery_type_email_show').find("[name='email']").val() == "") {
              error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter an email')}}</em>";
              $(theForm).find('.forgot_recovery_type_email_show').find("[name='email']").addClass("error_stroke");
              $(theForm).find(".forgot_recovery_type_email_show").find(".login_form_field").after(error_stroke);
            } else {
              mailStatus = 0;
            }
          }
          if (mailStatus === 0) {
              if (!re.test($('.forgot_recovery_type_email_show').find("[name='email']").val())) {
                error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Invalid email address')}}</em>";
                $(theForm).find('.forgot_recovery_type_email_show').find("[name='email']").addClass("error_stroke");
                $(theForm).find(".forgot_recovery_type_email_show").find(".login_form_field").after(error_stroke);
              }
          }
        }else{
          $('#type').val('phone');
          var phoneNo = $('.forgot_recovery_type_mob_show').find("[name='phone']").val();
          var isphone = /^[\+]?([0-9][\s]?|[0-9]?)([(][0-9]{3}[)][\s]?|[0-9]{3}[-\s\.]?)[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
          if ($('.forgot_recovery_type_mob_show').find("[name='phone']").val() != "" ){
              if(!isphone.test(phoneNo))
              {
                var error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Invalid phone number')}}</em>" ;
                $(theForm).find('.forgot_recovery_type_mob_show').find("[name='phone']").addClass("error_stroke");
                $(theForm).find('.forgot_recovery_type_mob_show').find(".login_form_field").after(error_stroke);
                status = false;
              }
          }else{
            var error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter your phone number')}}</em>" ;
            $(theForm).find('.forgot_recovery_type_mob_show').find("[name='phone']").addClass("error_stroke");
            $(theForm).find('.forgot_recovery_type_mob_show').find(".login_form_field").after(error_stroke);
            status = false;
          }
        }
      
      if (error_stroke !== "") {
        return false;
      } else {
        $(".login_submit").addClass("disabled");
        $(".login_error").hide();
        $(".fieldError_text").remove();
        return true;
      }
  }
	
  </script>
@stop