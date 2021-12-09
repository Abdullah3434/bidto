@extends('admin.layout.apps')

@section('content')
    <!--main content start-->
    <section id="main-content" class="">
        <section class="wrapper">
        <!-- page start-->
        <!-- page start-->
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Change Password
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {!! \Session::get('success') !!}

                            </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/change/password')}}" method="post" enctype="multipart/form-data"  onchange="return validateForm()">
                                    @csrf


                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Current Password</label>
                                                <div class="form-group{{ $errors->has('current_pass') ? ' has-error' : '' }}">
                                            
                                                    <input type="password"  oninput="return validateForm2()"  class="form-control" name="current_pass" >
                                                        @if ($errors->has('current_pass'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('current_pass') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                        </div>


                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">New Password</label>
                                                <div class="form-group{{ $errors->has('New Password') ? ' has-error' : '' }}">
                                            
                                                    <input type="password"  oninput="return validateForm2()"  class="form-control" name="new_pass" >
                                                        @if ($errors->has('New Password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('New Password') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Confirm Password</label>
                                                <div class="form-group{{ $errors->has('confirm_pass') ? ' has-error' : '' }}">
                                            
                                                    <input type="password"  oninput="return validateForm2()"  class="form-control" name="confirm_pass" >
                                                        @if ($errors->has('confirm_pass'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('confirm_pass') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                        </div>
                                        
                                         
                           
                              
                               
                                            <button type="submit" id="submit" class="btn btn-info">Submit</button>

                              
                                </form>
                            </div>

                        </div>
                    </section>

                </div>
           
            </section>

        </div>
    </div>
</section>

@endsection