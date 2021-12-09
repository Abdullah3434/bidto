@extends('front.layout.auth')

@section('content')
<div class="login_form_box">
    <div class="login_form_section">
      <div class="login_title_text accountVerified_textCircle"> 
        <span class="accountVerified_circle">
          <img src="{{asset('public/front_assets/images/account_verified_circle.svg')}}" alt="#">
        </span>
        <h2>{{Lang::get("label.Account Verified!")}}</h2>
        <p>{{ Session::get('success_message') }}</p>
      </div>
      <div class="login_submit"> 
        <a href="{{url('/login')}}" class="all_buttons all_green has_icon has_login_icon login_submit_btn">{{Lang::get("label.Login")}}</a>
      </div>
    </div>
</div>
@endsection
<script type="text/javascript">
</script>
