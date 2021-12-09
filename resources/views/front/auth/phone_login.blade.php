@extends('front.layout.auth')

@section('content')
    <div class="login_form_box">
      <div class="login_form_section">
        <div class="login_title_text">
          <h2>{{Lang::get("label.Login")}}</h2>
          <p>{{Lang::get("label.Login to start managing your assets and monitoring updates.")}}</p>
        </div>

        @include('front.layout.social_login')

        @include('front.flash_message')

        <form name="formname" onsubmit="return login_form(this);" method="POST"  action="{{url('/login')}}">
          {{ csrf_field() }}
          <div class="login_form">
            <div class="login_field_row login_phone_row"> 
              <strong class="login_field_title login_phone_icon">{{Lang::get("label.Phone Number")}}</strong>
              <div class="login_form_field">
                <input type="text" name="email_mobile" placeholder="{{Lang::get('label.Phone Number')}}" onClick="phone_number_click(this)" value="{{ old('email_mobile')?old('email_mobile'):@$_COOKIE['user_phone']}}">
              </div>
            </div>
            <div class="login_field_row login_pw_row"> 
              <strong class="login_field_title login_pw_icon">{{Lang::get("label.Password")}}</strong>
              <div class="login_form_field">
                <input type="password" name="password" placeholder="**********" value="{{ old('password')?'':@$_COOKIE['password']}}">
              </div>
            </div>
            <div class="login_field_row login_pw_row">
              <div class="forgetPw_rememberParent">
                <div class="form_checkbox inline_checkbox login_rememberMe_check">
                  <label> {{Lang::get("label.Remember me")}}
                    <input data-id="everyone" type="checkbox" class="login_rememberMe_check_input" value="">
                    <span class="checkbox_checked"></span> </label>
                </div>
                <a class="forgetPw_link" href="{{url('/forgot-password')}}">{{Lang::get("label.Forget Password?")}}</a> </div>
            </div>
            <div class="login_field_row">
              <div class="loginWithEmail_link_outer"> 
                <a class="loginWithEmail_link" href="{{url('/login')}}">{{Lang::get("label.Login with Email")}}</a> 
              </div>
              <div class="login_submit">
                <input class="all_buttons all_green has_icon has_login_icon login_submit_btn" type="submit" value="{{Lang::get('label.Login')}}">
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
      ////////////////////////
      });
 
 
    /*login from validation start here*/
    function login_form(theForm) {
      var mailStatus = 1;
      var error_stroke = "";
      $(".login_form_field input, .login_form_field textarea, .selectbox").removeClass("error_stroke");
      $(".fieldError_text").remove();

    
	    var phoneNo = $("[name='email_mobile']").val();
		var isphone = /^[\+]?([0-9][\s]?|[0-9]?)([(][0-9]{3}[)][\s]?|[0-9]{3}[-\s\.]?)[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    if(phoneNo.length == ""){
      var error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter your phone number')}}</em>" ;
			$(theForm).find("[name='email_mobile']").addClass("error_stroke");
			$(theForm).find("[name='email_mobile']").closest(".login_form_field").after(error_stroke);
			status = false;
    }else{
      if (!isphone.test(phoneNo))
      {
        var error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Invalid phone number')}}</em>" ;
        $(theForm).find("[name='email_mobile']").addClass("error_stroke");
        $(theForm).find("[name='email_mobile']").closest(".login_form_field").after(error_stroke);
        status = false;
      }
    }
		
	  

      if (theForm.password.value == "") {
		     error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter your password')}}</em>";
         $(theForm).find("[name='password']").addClass("error_stroke");
         $(theForm).find("[name='password']").closest(".login_form_field").after(error_stroke);
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