@extends('front.layout.auth')

@section('content')
    <div class="login_form_box"> 
      <a class="otp_back_arrow" href="{{url('/reset-verification?phone=').@$phone.'&emailmobile='.base64_encode(@$email_mobile)}}"></a>
      <div class="login_form_section">
        <div class="login_title_text">
          <h2>{{Lang::get("label.Reset Password")}}</h2>
          <p>{{Lang::get("label.You will use this new password to access your account")}}</p>
        </div>

        @include('front.layout.social_login')
        @include('front.flash_message')

        <form name="formname" onsubmit="return loginResetPw_save(this);" method="POST" action="{{url('/reset-password')}}">
          {{ csrf_field() }}
          <div class="login_form">
          <input type="hidden" name="phone" value="{{@$phone}}">
            <input type="hidden" name="verify_token" value="{{$otp_token}}">
            <input type="hidden" name="email_mobile" value="{{$email_mobile}}">

            <div class="login_field_row login_pw_row"> 
              <strong class="login_field_title login_pw_icon">{{Lang::get("label.Password")}}</strong>
              <div class="login_form_field">
                <input type="password" name="password" placeholder="**********">
                <i class="confirmField_show_pw"></i> </div>
            </div>
            <div class="login_field_row login_pw_row"> 
              <strong class="login_field_title login_pw_icon">{{Lang::get("label.Confirm Password")}}</strong>
              <div class="login_form_field">
                <input type="Password" name="confirm_password" placeholder="**********">
                <i class="confirmField_show_pw"></i> </div>
            </div>
            <div class="login_field_row">
              <div class="login_submit">
                <input class="all_buttons all_green has_icon has_tick_icon confirmResetPw_submit_btn" type="submit" value="{{Lang::get('label.Confrim and Reset')}}">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
   
@endsection
@section('javascript')
<script type="text/javascript">
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
      ////////////////////////
      });
 
	
	function loginResetPw_save(theForm) {
      $(".login_error").hide();
      $(".fieldError_text").remove();
      var mailStatus = 1;
      var error_stroke = "";
      var pw_status = false;
      $(".login_form_field input, .login_form_field textarea, .selectbox").removeClass("error_stroke");
      $(".login_submit").removeClass("disabled");


      var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
 
      if (pw_status === false) {
        if (theForm.password.value == "") {
          error_stroke = "<b class='fieldError_text'>{{Lang::get('message.Please enter your new password')}}</b>";
          $(theForm).find("[name='password']").addClass("error_stroke");
          $(theForm).find("[name='password']").closest(".login_form_field").after(error_stroke);

        } else {
          if (theForm.confirm_password.value <= 0) {
            pw_status = false
          } else {
            pw_status = true
          }
        }

        var upperCase = new RegExp('[A-Z]');
        var lowerCase = new RegExp('[a-z]');
        var numbers = new RegExp('[0-9]');
        var field = $("[name='password']");
        var len = $("[name='password']").val().length;

        if (theForm.password.value != "") {
          if ($(field).val().match(upperCase) && $(field).val().match(lowerCase) && $(field).val().match(numbers) && len > 7) {

          }
          else {
            error_stroke = "<b class='fieldError_text'>{{Lang::get('message.Your password must be minimum 8 characters. It must contain a mixture of upper and lower case letters, and at least one number.')}}</b>";
            $(theForm).find("[name='password']").addClass("error_stroke");
            $(theForm).find("[name='password']").closest(".login_form_field").after(error_stroke);
          }
        }
      }
      if (pw_status === false) {
        if (theForm.confirm_password.value == "") {
          error_stroke = "<b class='fieldError_text'>{{Lang::get('message.Please enter your new password.')}}</b>";
          $(theForm).find("[name='confirm_password']").addClass("error_stroke");
          $(theForm).find("[name='confirm_password']").closest(".login_form_field").after(error_stroke);
        } else {
          if (theForm.password.value <= 0) {
            pw_status = false
          } else {
            pw_status = true
          }
        }
      }



      if (pw_status === true) {
        if (theForm.password.value !== theForm.confirm_password.value) {
          error_stroke = "<b class='fieldError_text'>{{Lang::get('message.Password does not match.')}}</b>";
          $(theForm).find("[name='confirm_password']").addClass("error_stroke");
          $(theForm).find("[name='confirm_password']").closest(".login_form_field").after(error_stroke);
        }
      }



      if (error_stroke !== "") {
        return false;
      } else {
        // $(".confirmJoin_btnMain span").addClass("disabled");
        $(".fieldError_text").remove();
       $(".login_submit").addClass("disabled");
        return true;
      }
    }
 
  </script>
@stop