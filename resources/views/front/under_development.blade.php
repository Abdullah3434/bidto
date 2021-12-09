<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, user-scalable=0">
    <title>{{settingValue('app_name')}}</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('public/front_assets/images/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('public/front_assets/images/favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('public/front_assets/images/favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('public/front_assets/images/favicon/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('public/front_assets/images/favicon/safari-pinned-tab.svg')}}" color="#666666">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/front_assets/css/slick.css')}}">
    <script type="text/javascript" src="{{asset('public/front_assets/js/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/front_assets/js/my_script.js')}}"></script>
    <script type="text/javascript" src="{{asset('public/front_assets/js/slick.min.js')}}"></script>
</head>
<body class="updating_app_body">

<div class="updating_app_wrap">
    <div class="updating_app_auto">
        <div class="updating_app_cell">
            <div class="updating_app_content">
                <span class="updating_app_logo">
                    <img src="{{asset('public/front_assets/images/logo.svg')}}" alt="#">
                </span>
                <span class="updating_app_grari">
                    <img src="{{asset('public/front_assets/images/under_development_grari.svg')}}" alt="#">
                </span>
                <h3>Under Maintenance</h3>
                <p>{{settingValue('site_down_message')}}</p>

                <div class="updates_copyRights">
                    <span>{!! settingValue('copy_right_text')!!}</span>
                </div>

            </div>
        </div>

    </div>

</div>


</body>
</html>
