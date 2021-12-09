@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Notification Templates   
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/notification/template/'.$ifexist->id)}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf
 
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Notification Name </label>
                                    <div class="form-group{{ $errors->has('notification_name') ? ' has-error' : '' }}">
                                    <input type="text" oninput="return validateForm2()" id="text1" class="form-control" name="notification_name" value="{{$ifexist->notification_name}}">
                                    
                                    @if ($errors->has('notification_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('notification_name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                              

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Notification Content </label>
                                    <div class="form-group{{ $errors->has('notification_content') ? ' has-error' : '' }}">
                                    <textarea  name="notification_content"   rows="8" cols="50" class="form-control" > {{$ifexist->notification_content}}</textarea>
                                    <p> please do not change text in {}. </p>
                                    @if ($errors->has('notification_content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('notification_content') }}</strong>
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
        <script>
                                function validateForm() {
                                var x = document.forms["myForm"]["notification_name"].value;
                                if (x == "" || x == null) {
                                    document.getElementById("submit").disabled = true;
                                
                                }
                                
                                }

                                function validateForm2() {
                                var x = document.forms["myForm"]["notification_name"].value;
                                if (x >0  || x != null) {
                                    document.getElementById("submit").disabled = false;
                                
                                }

                                }
                            </script>

        

</section>

@endsection
