<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="{{URL('public/favicon.ico') }}">

    <title>Admin Login</title>

    <!--Core CSS -->
    <link href="{{URL('public/admin_assets/bs3/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{URL('public/admin_assets/css/bootstrap-reset.css') }}" rel="stylesheet">
    <link href="{{URL('public/admin_assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{URL('public/admin_assets/css/style.css') }}" rel="stylesheet">
    <link href="{{URL('public/admin_assets/css/style-responsive.css') }}" rel="stylesheet" />

   
</head>

  <body class="login-body">
        @yield('content')
        <script src="{{URL('public/admin_assets/js/jquery.js') }}"></script>
        <script src="{{URL('public/admin_assets/bs3/js/bootstrap.min.js') }}"></script>

  </body>
</html>