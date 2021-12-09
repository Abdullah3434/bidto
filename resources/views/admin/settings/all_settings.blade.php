@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Setting
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                           
                                <form name="myForm" action="{{url('/admin/edit/setting')}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf


                                  
                                    
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">site_is_down</label>
                                    <div class="form-group{{ $errors->has('site_is_down') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="site_is_down" value="{{$site_is_down->value}}">
                                 
                                    @if ($errors->has('site_is_down'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('site_is_down') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">login_attempts</label>
                                    <div class="form-group{{ $errors->has('login_attempts') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="login_attempts" value="{{$login_attempts->value}}">
                                   
                                    @if ($errors->has('login_attempts'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('login_attempts') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                             
                           
       
                                    <button type="submit" id="submit" class="btn btn-info" style="margin-top:10px">Submit</button>
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
