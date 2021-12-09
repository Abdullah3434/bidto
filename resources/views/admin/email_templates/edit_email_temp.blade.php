@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Email Templates   
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/email-temp/'.$ifexist->id)}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf
 
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Email Name </label>
                                    <div class="form-group{{ $errors->has('email_name') ? ' has-error' : '' }}">
                                    <input type="text" oninput="return validateForm2()" id="text1" class="form-control" name="email_name" value="{{$ifexist->email_name}}">
                                    
                                    @if ($errors->has('email_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Email Subject </label>
                                    <div class="form-group{{ $errors->has('email_subject') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm2()" id="text1" class="form-control" name="email_subject" value="{{$ifexist->email_subject}}">
                                    
                                    @if ($errors->has('email_subject'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_subject') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Email Content </label>
                                    <div class="form-group{{ $errors->has('email_content') ? ' has-error' : '' }}">
                                    <textarea id="editor" name="email_content"   rows="4" cols="50"> {{$ifexist->email_content}}</textarea>
                                    <p> please do not change text in {}. </p>
                                    @if ($errors->has('email_content'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email_content') }}</strong>
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
                                var x = document.forms["myForm"]["condition_name"].value;
                                if (x == "" || x == null) {
                                    document.getElementById("submit").disabled = true;
                                
                                }
                                
                                }

                                function validateForm2() {
                                var x = document.forms["myForm"]["condition_name"].value;
                                if (x >0  || x != null) {
                                    document.getElementById("submit").disabled = false;
                                
                                }

                                }
                            </script>
  <script>
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
           
    </script>
        

</section>

@endsection
