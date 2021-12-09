@extends('front.layout.auth')

@section('content')
  <div class="login_form_box"> 
    <a class="otp_back_arrow" href="{{url('/register')}}"></a>
    <div class="login_form_section">
      <div class="login_title_text">
        <h2>{{Lang::get("label.OTP")}}</h2>
        <p>{!!Lang::get("label.Enter the 4-digits code sent to your <br>email/mobile number")!!}</p>
      </div>

      <div class="successMsg" style="display: none"></div>
      <div class="errorMsg" style="display: none"></div>
      
      @include('front.flash_message')

      <form name="formname"  method="POST" action="{{url('/code-verification')}}">
          {{ csrf_field() }}
          <input type="hidden" name="otp" id="otp" value="">
          <input type="hidden" name="email" id="email" value="{{$email_mobile}}">
          <input type="hidden" name="photo_id" id="photo_id" value="{{ old('photo_id')?old('photo_id'):''}}">
          <input type="hidden" name="name" id="name" value="{{ old('name')?old('name'):''}}">
          <input type="hidden" name="password" id="password" value="{{ old('password')?old('password'):''}}">
          <input type="hidden" name="phone_number" id="phone_number" value="{{ old('phone_number')?old('phone_number'):''}}">
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
                <a class="loginWithEmail_link resendVarificationCode_link " href="javascript:void(0)">{{Lang::get("label.Resend Verification Code")}}</a> 
              </div>
              <div class="login_submit">
                <input class="all_buttons all_green otp_resetPw_btn" type="submit" value="{{Lang::get('label.Verify OTP')}}">
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

      dataObject = {
        email_mobile   : '{{$email_mobile}}',
      }
      $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
      $.ajax({
          url: "{{ url('/resend-otp') }}",
          type: 'POST',
          data: {'dataObject' : dataObject},
      }).done(function (result) {
          console.log(result);
          var obj = jQuery.parseJSON(result);
          $('.login_right').removeClass('is_loading');

          $(".otp_field1").val('');
          $(".otp_field2").val('');
          $(".otp_field3").val('');
          $(".otp_field4").val('');

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