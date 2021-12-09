@extends('admin.layout.auth')

@section('content')

    <div class="container">

        <form class="form-signin" action="{{ url('/admin/password/email') }}" method="post">
            @csrf


        <h2 class="form-signin-heading">Reset Password</h2>



            <div class="login-wrap">

            @if (\Session::has('success'))
                <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                        {!! \Session::get('success') !!}
                    
                </div>
            @endif

            @if (\Session::has('message'))
                <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                        {!! \Session::get('message') !!}
                    
                </div>
            @endif
            <br>
                    <div class="user-login-info">
                        <div class="form-group{{ $errors->has('admin_email') ? ' has-error' : '' }}">
                            <input id="email" type="text" class="form-control" name="admin_email" value="{{ old('admin_email') }}" placeholder="Enter Recovery Email">

                                @if ($errors->has('admin_email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('admin_email') }}</strong>
                                    </span>
                                @endif
                        </div>
                       
                        <span class="pull-right">
                            <a  href="{{url('admin/login') }}"> Go to Login Page</a>
                        </span>
                    </div>
     
                <button class="btn btn-lg btn-login btn-block" type="submit">Reset Password</button>

             </div>
        </form>
   



    </div>
@endsection

