@extends('admin.layout.auth')

@section('content')
    <div class="container">

        <form class="form-signin" action="{{ url('/admin/password/reset') }}" method="post">
            @csrf

            <input type="hidden" class="form-control" name="token" value="{{$token}}">

                <h2 class="form-signin-heading">Reset Password</h2>


                <div class="login-wrap">

                @if (\Session::has('success'))
                        <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                                {!! \Session::get('success') !!}
                            
                        </div>
                    @endif
                    <br> 
                    <div class="user-login-info">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                
                            <input id="email" type="text" class="form-control" name="email" placeholder="Enter Email" value="{{ old('email') }}" autocomplete="off" autofocus>
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
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Re-Type Password">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif

                            </div>
                    </div>
     
                        <button class="btn btn-lg btn-login btn-block" type="submit">Reset Now</button>

                </div>
            </form>

        </div>
@endsection


