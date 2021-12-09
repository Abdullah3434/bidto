@extends('front.layout.auth')

@section('content')
  <div class="login_form_box"> 
    <a class="otp_back_arrow" href="{{url('/forgot-password?phone=').@$phone}}"></a>
    <div class="login_form_section">
      <div class="login_title_text">
        <h2>{{Lang::get("label.OTP")}}</h2>
        <p>{!! Lang::get("label.We've sent you an email/text with verification <br>code to reset password") !!}</p>
      </div>
      <div class="successMsg" style="display: none"></div>
      <div class="errorMsg" style="display: none"></div>
      
      @include('front.flash_message')
      <form name="formname"  method="POST" action="{{url('/reset-verification')}}">
          {{ csrf_field() }}
          <input type="hidden" name="phone" id="phone" value="{{@$phone}}">
          <input type="hidden" name="otp" id="otp" value="">
          <input type="hidden" name="email_mobile" id="email_mobile" value="{{$email_mobile}}">
          <div class="otp_fields_row clearfix">
            <ul>
              <li>
                <input class="otp_field otp_field1" type="text" placeholder="0" maxlength="1">
              </li>
              <li>
                <input class="otp_field otp_field2" type="text" placeholder="0" maxlength="1">
              </li>
              <li>
                <input class="otp_field otp_field3" type="text" placeholder="0" maxlength="1">
              </li>
              <li>
                <input class="otp_field otp_field4" type="text" placeholder="0" maxlength="1">
              </li>
            </ul>
          </div>
          <div class="login_form">
            <div class="login_field_row">
              <div class="loginWithEmail_link_outer"> 
                <a class="loginWithEmail_link resendVarificationCode_link" href="javascript:void(0)">{{Lang::get("label.Resend Verification Code")}}</a> 
              </div>
              <div class="login_submit">
                <input class="all_buttons all_green otp_resetPw_btn" type="submit" value="{{Lang::get('label.Reset Password')}}">
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>
    
@endsection
@section('javascript')
<script type="text/javascript">
//Resend OTP
$(document).on("click",".resendVarificationCode_link",function(e){
      $('.errorMsg').html('');
      $('.successMsg').html('');
      $('.alert').find('p').html('');
      $('.login_right').addClass('is_loading');


      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
      $.ajax({
          url: "{{ url('/forgot-password') }}",
          type: 'POST',
          data: {'email_mobile' : '{{$email_mobile}}','type':'combine'},
      }).done(function (result) {
          console.log(result);
          var obj = jQuery.parseJSON(result);
          $('.login_right').removeClass('is_loading');
          if(obj.status===false){
              $('.errorMsg').html(obj.message).show();
              $(".otp_field1").focus();
          }else{
              $('.successMsg').html(obj.message).show();
          }
      });
});
$('.otp_field').on('keyup', function (e) {
    $('.errorMsg').hide();
    $('.successMsg').hide();
    $('.alert').find('p').html('');
    var otp1 = $(".otp_field1").val();
    var otp2 = $(".otp_field2").val();
    var otp3 = $(".otp_field3").val();
    var otp4 = $(".otp_field4").val();
    var otp = otp1.toString() + otp2.toString() + otp3.toString() + otp4.toString();
    console.log(otp);
    $('#otp').val(otp);
});
</script>
@stop
