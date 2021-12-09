@extends('front.layout.auth')

@section('content')
  <div class="login_form_box">
    <div class="login_form_section">
      <div class="login_title_text">
        <h2>{{Lang::get("label.Register")}}</h2>
        <p>{{Lang::get("label.Create a new account to start managing your assets today.")}}</p>
      </div>
      
      @include('front.layout.social_login')

      @include('front.flash_message')

      <form name="formname" onsubmit="return login_form(this);" method="POST" action="{{url('/register')}}"  enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="reg_upload_row">
          <div class="reg_upload_left">
            <div class="reg_upload_placeholder"> 
              	@php
                  $image_name = asset('public/front_assets/images/profile_avatar.png');
                @endphp
              <img class="upload_pic" src="{{$image_name}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/front_assets/images/profile_avatar.png')}}'">
            </div>
          </div>
          <div class="reg_upload_right">
            <div class="reg_upload_fileBox">
              <input class="reg_upload_file" type="file" accept="image/*" name="photo" id="photo" >
            </div>
          </div>
        </div>
        <div class="login_form">
          <div class="login_field_row login_email_row"> 
            <strong class="login_field_title login_user_icon">{{Lang::get("label.Full Name")}}</strong>
            <div class="login_form_field">
              <input type="text" name="name" placeholder="{{Lang::get('label.Full Name')}}" value="{{ old('name')?old('name'):''}}">
            </div>
          </div>
          <div class="login_field_row login_email_row"> 
            <strong class="login_field_title login_email_icon">{{Lang::get("label.Email Address")}}</strong>
            <div class="login_form_field">
              <input type="text" name="email" placeholder="{{Lang::get('label.Email Address')}}" value="{{ old('email')?old('email'):''}}">
            </div>
          </div>
          <div class="login_field_row login_phone_row"> 
            <strong class="login_field_title login_phone_icon">{{Lang::get("label.Phone Number")}}</strong>
            <div class="login_form_field">
              <input type="text" name="phone_number" placeholder="{{Lang::get('label.Phone Number')}}" onClick="phone_number_click(this)" value="{{ old('phone_number')?old('phone_number'):''}}">
            </div>
          </div>
          <div class="login_field_row login_pw_row"> 
            <strong class="login_field_title login_pw_icon">{{Lang::get("label.Password")}}</strong>
            <div class="login_form_field">
              <input type="password" name="password" placeholder="**********">
              <i class="confirmField_show_pw"></i> 
            </div>
          </div>
          <div class="login_field_row reg_pw_infoLong">
            <ul>
              <li>{{Lang::get("label.Be 8 to 72 characters long")}}</li>
              <li>{{Lang::get("label.not contain your name or email")}}</li>
              <li>{{Lang::get("label.not be commonly used or easily guessed")}}</li>
            </ul>
          </div>
          <div class="login_field_row">
            <div class="login_submit">
              <input class="all_buttons all_green has_icon has_sighnUp_icon signup_submit_btn" type="submit" value="{{Lang::get('label.Sign Up')}}">
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

    $('.reg_upload_fileBox input[type="file"]').change(function(e){
      var file = e.target.files[0]
      if (file) {
        var url =  URL.createObjectURL(file);
        $(".reg_upload_placeholder img").attr("src", url);
        $(this).closest(".reg_upload_placeholder").addClass("active");
        $(".reg_upload_placeholder").removeClass("error_stroke");
        $(".reg_upload_placeholder").find(".error_text").remove();
      }
    });

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

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var totallane_user_email = theForm.email;

    /*if (theForm.photo.value == "") {
      error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please upload photo')}}</em>";
      $(".reg_upload_placeholder").addClass("error_stroke");
      $(".reg_upload_left ").append(error_stroke);
    }else{
      var val = theForm.photo.value;
      if (!val.match(/(?:jpeg|jpg|png|gif|svg)$/)) {
          // inputted file path is not an image of one of the above types
          error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please upload valid photo')}}</em>";
          $(".reg_upload_placeholder").addClass("error_stroke");
          	$(".reg_upload_left ").append(error_stroke);
      }
    }*/
    if(theForm.photo.value != ""){
      var val = theForm.photo.value;
      if (!val.match(/(?:jpeg|jpg|png|gif|svg)$/)) {
          // inputted file path is not an image of one of the above types
          error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please upload valid photo')}}</em>";
          $(".reg_upload_placeholder").addClass("error_stroke");
          	$(".reg_upload_left ").append(error_stroke);
      }
    }

    if (theForm.name.value == "") {
      error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter your name')}}</em>";
      $(theForm).find("[name='name']").addClass("error_stroke");
      $(theForm).find("[name='name']").closest(".login_form_field").after(error_stroke);
    }

    if (theForm.email.value.length <= 0) {
      mailStatus = 1;
    }

    if (mailStatus === 1) {
      if (theForm.email.value.length == "") {
        error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter an email')}}</em>";
        $(theForm).find("[name='email']").addClass("error_stroke");
        $(theForm).find("[name='email']").closest(".login_form_field").after(error_stroke);
      } else {
        mailStatus = 0;
      }
    }

    if (mailStatus === 0) {
      if (!re.test(theForm.email.value)) {
        error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Invalid email address')}}</em>";
        $(theForm).find("[name='email']").addClass("error_stroke");
        $(theForm).find("[name='email']").closest(".login_form_field").after(error_stroke);
      }
    }

    var phoneNo = $("[name='phone_number']").val();
    var isphone = /^[\+]?([0-9][\s]?|[0-9]?)([(][0-9]{3}[)][\s]?|[0-9]{3}[-\s\.]?)[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
    if (theForm.phone_number.value != "" ){
        if(!isphone.test(phoneNo))
        {
          error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Invalid phone number')}}</em>" ;
          $(theForm).find("[name='phone_number']").addClass("error_stroke");
          $(theForm).find("[name='phone_number']").closest(".login_form_field").after(error_stroke);
          status = false;
        }
    }
  
    var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,20}$/;
    if (theForm.password.value == "") {
      error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Please enter your password')}}</em>";
      $(theForm).find("[name='password']").addClass("error_stroke");
      $(theForm).find("[name='password']").closest(".login_form_field").after(error_stroke);
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
            error_stroke = "<em class='fieldError_text'>{{Lang::get('message.Your password must be minimum 8 characters. It must contain a mixture of upper and lower case letters, and at least one number.')}}</em>";
            $(theForm).find("[name='password']").addClass("error_stroke");
            $(theForm).find("[name='password']").closest(".login_form_field").after(error_stroke);
          }
    }


    if (error_stroke !== "") {
        $('html, body').animate({
            scrollTop: $('.reg_upload_row').offset().top
        }, 'smooth');
        
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