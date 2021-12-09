<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=0">
<title>@if(isset($meta_title) && @$meta_title!=''){{ @$meta_title}}@else{{settingValue('app_name')}}@endif</title>

<!--favicon-->
<link rel="apple-touch-icon" sizes="152x152" href="{{asset('public/front_assets/images/favicon/apple-touch-icon.png')}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{asset('public/front_assets/images/favicon/favicon-32x32.png')}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/front_assets/images/favicon/favicon-16x16.png')}}">
<link rel="manifest" href="{{asset('public/front_assets/images/favicon/site.webmanifest')}}">
<link rel="mask-icon" href="{{asset('public/front_assets/images/favicon/safari-pinned-tab.svg')}}" color="#81e1ba">
<meta name="msapplication-TileColor" content="#81e1ba">
<meta name="theme-color" content="#ffffff">
<!--favicon-->

<!--meta data-->
<meta name="csrf-token" content="{{csrf_token()}}">
@if(isset($meta_description) && @$meta_description!='')
    <meta name="description" content={{ @$meta_description}}>
@endif
@if(isset($meta_keywords) && @$meta_keywords!='')
    <meta name="keywords" content={{ @$meta_keywords}}>
@endif
<!--meta data-->

<!--Cairo, Poppins Google fonts-->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&display=swap" rel="stylesheet">
<!--Cairo, Poppins Google fonts end-->

<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/slick.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/responsive.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/font-awesome.min.css')}}">

</head>
<script>
    var APP_URL = "{{ url('/') }}";
</script>
<body class="home_body">
    <div class="login_wrapper"> 
        <div class="login_content">
            <div class="login_left">
                <div class="login_detail">
                    <div class="login_slogen">
                        <span>
                            <img src="{{asset('public/front_assets/images/login_logo.svg')}}" alt="#">
                        </span>
                    </div>
                    <h1>{{Lang::get("label.Welcome to Bidto")}}</h1>
                    <p>{{Lang::get("label.Buying and selling made easy! start using our platform today")}}</p>
                    <div class="login_detail_buttons">
                        <ul>
                            @if(isFrontActiveRoute('login')!='active' && isFrontActiveRoute('phone_login')!='active' && isFrontActiveRoute('success_verification')!='active')
                            <li>
                                @php 
                                    
                                        $login_class = 'all_green has_login_icon';
                                @endphp
                                <a class="all_buttons has_icon {{$login_class}}" href="{{url('/login')}}">{{Lang::get("label.Login")}}</a>
                            </li>
                            @endif
                            @if(isFrontActiveRoute('register')!='active')
                            <li>
                                
                                <a class="all_buttons has_icon has_userPlus_icon" href="{{url('/register')}}">{{Lang::get("label.Sign Up")}}</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="login_right">
                @yield('content')
            </div>
        </div>
    </div>
    
    <script src="{{asset('public/front_assets/js/jquery-3.5.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/front_assets/js/jquery.mask.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/front_assets/js/my_script.js')}}"></script>

    @yield('javascript')

    <script type="text/javascript">
    </script>
</body>
</html>