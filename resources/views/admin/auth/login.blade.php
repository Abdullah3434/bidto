@extends('admin.layout.auth')

@section('content')

<div class="container">

    <form class="form-signin" action="{{url('/admin/login')}}" method="post">
        @csrf
        <h2 class="form-signin-heading">sign in now</h2>
       
        <div class="login-wrap">
            @if (\Session::has('success'))
                <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    {!! \Session::get('success') !!}
                </div>
            @endif
 
            @if (\Session::has('msg'))
                <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    {!! \Session::get('msg') !!}

                </div>
            @endif
            <br>
                <div class="user-login-info"> 
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="text" class="form-control" name="email" placeholder="Enter Email"  autocomplete="off" autofocus  value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input type="password" class="form-control" placeholder="Enter Password" name="password" >

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                    </div> 
                </div>
                    <label class="checkbox">
                        <input type="checkbox" value="remember-me"> Remember me
                        <span class="pull-right">
                            <a  href="{{url('admin/password/reset') }}"> Forgot Password?</a>
                        </span>
                    </label>
                        <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
            </div>
        </form>
    </div>
@endsection


