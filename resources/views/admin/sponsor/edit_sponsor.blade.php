@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Sponsor
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">

                                {!! \Session::get('success') !!}

                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/sponsor/'.$ifexist->id)}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf


                                   
                                    
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Sponsor Name </label>
                                    <div class="form-group{{ $errors->has('sponsor_name') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm()" id="text1" class="form-control" name="sponsor_name" value="{{$ifexist->sponsor_name}}">
                                    
                                    @if ($errors->has('sponsor_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sponsor_name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Sponsor URL </label>
                                    <div class="form-group{{ $errors->has('sponsor_url') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm()" id="text1" class="form-control" name="sponsor_url" value="{{$ifexist->sponsor_url}}">
                                    
                                    @if ($errors->has('sponsor_url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('sponsor_url') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="form-group{{ $errors->has('sponsor_image') ? ' has-error' : '' }}">
                                    <input type="file"  name="sponsor_image" style="padding:3px 4px" class="form-control fileControl" value="{{asset('public/uploads/sponsors/'.$ifexist->sponsor_image)}}"  id="sponsor_image" onchange="loadPreview(this);">

                                    @if ($errors->has('sponsor_image'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('sponsor_image') }}</strong>
                                      </span>
                                  @endif
                                    </div>

                        <label for="profile_image"></label>
                        <img id="preview_img" src="{{asset('public/uploads/sponsors/thumbs/'.$ifexist->sponsor_image)}}" class="" width="200" height="150"  onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';"/>
                        <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
                     
                                </div>


                           <script>
                                function validateForm() {
                                var x = document.forms["myForm"]["sponsor_name","sponsor_url"].value;
                                if (x == "" || x == null) {
                                    document.getElementById("submit").disabled = true;
                                
                                }
                                elseif (x >0  || x != null) {
                                    document.getElementById("submit").disabled = false;
                                
                                }
                                
                                }

                                // function validateForm2() {
                                // var x = document.forms["myForm"]["sponsor_name","sponsor_url"].value;
                                // if (x >0  || x != null) {
                                //     document.getElementById("submit").disabled = false;
                                
                                // }

                                // }
                            </script>
     
                                    <button type="submit" id="submit" class="btn btn-info" style="margin-top:10px">Submit</button>
                                </form>
                            </div>

                        </div>
                    </section>

            </div>
            <script>
    function remove2(){
    $('#preview_img').attr('src', 'http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png'); 
    $(".fileControl").val('');
    }
    </script>
        </section>

        </div>
        </div>


</section>

@endsection
