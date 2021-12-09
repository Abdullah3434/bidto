@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Reviews
                        </header>
                        <div class="panel-body">
                              
                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                    
                                            {!! \Session::get('success') !!}
                                        
                                    </div>
                                @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/reviews/'.$ifexist->id.'/'.$to_id)}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf
                                    <div class="form-group" >
                                <label for="exampleInputEmail1">Rating </label>
                                <div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
                                <input type="number" oninput="return validateForm2()" id="text1" class="form-control" name="rating" value="{{$ifexist->rating}}"  min="0.1" max="5.00" step="0.1">
                                    
                                    @if ($errors->has('rating'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('rating') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Comment </label>
                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                    <textarea  class="form-control" name="comment" rows="8"  cols="5">{{$ifexist->comment}}</textarea>
                                    
                                        @if ($errors->has('comment'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                           
                           
                         
                            <script>
                                function validateForm() {
                                var x = document.forms["myForm"]["rating","comment"].value;
                                if (x == "" || x == null) {
                                    document.getElementById("submit").disabled = true;
                                
                                }
                                
                                }

                                function validateForm2() {
                                var x = document.forms["myForm"]["rating","comment"].value;
                                if (x >0  || x != null) {
                                    document.getElementById("submit").disabled = false;
                                
                                }

                                }
                            </script>
 
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
