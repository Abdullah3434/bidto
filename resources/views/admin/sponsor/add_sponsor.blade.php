@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Sponsor
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">

                                {!! \Session::get('success') !!}

                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/add/sponsor')}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf


                                   
                                    
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Sponsor Name </label>
                                    <div class="form-group{{ $errors->has('sponsor_name') ? ' has-error' : '' }}">
                                    <input type="text"   oninput="return validateForm2()" class="form-control " name="sponsor_name" placeholder="Sponsor Name" value="{{ old('sponsor_name') }}">
                                    
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
                                    <input type="text"   oninput="return validateForm2()" class="form-control " name="sponsor_url" placeholder="Sponsor URL" value="{{ old('sponsor_url') }}">
                                    
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
                                    <input type="file"  name="sponsor_image" style="padding:3px 4px" class="form-control fileControl"   id="sponsor_image" onchange="loadPreview(this);">

                                    @if ($errors->has('sponsor_image'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('sponsor_image') }}</strong>
                                      </span>
                                  @endif
                                    </div>

                        <label for="profile_image"></label>
                        <img id="preview_img" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="200" height="150"/>
                        <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
                     
                                </div>


     
                                    <button type="submit" id="submit" class="btn btn-info " style="margin-top:10px">Submit</button>
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
                                    <script>
                                            function validateForm() 
                                            {
                                                var x = document.forms["myForm"]["sponsor_url","sponsor_name"].value;
                                                if (x == "" || x == null) {
                                                    document.getElementById("submit").disabled = true;
                                                
                                                }

                                                
                                                }

                                                function validateForm2() {
                                                var x = document.forms["myForm"]["sponsor_url","sponsor_name"].value;
                                                if (x >0  || x != null) {
                                                    document.getElementById("submit").disabled = false;
                                                
                                                }

                                            }
                                        </script>
    
    
        </section>

        </div>
        </div>


</section>

@endsection
