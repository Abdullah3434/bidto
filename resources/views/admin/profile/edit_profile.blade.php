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
                            Edit Profile
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            {!! \Session::get('success') !!}

                            </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/profile/edit')}}" method="post" enctype="multipart/form-data"  onchange="return validateForm()">
                                    @csrf


                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Admin Name</label>
                                            <div class="form-group{{ $errors->has('admin_name') ? ' has-error' : '' }}">
                                            
                                            <input type="text"  oninput="return validateForm2()"  class="form-control" name="admin_name" value="{{$ifexist[0]->admin_name}}">
                                            @if ($errors->has('admin_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('admin_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <script>
                                        function validateForm() {
                                            var x = document.forms["myForm"]["admin_name"].value;
                                            if (x == "" || x == null) {
                                                document.getElementById("submit").disabled = true;
                                            
                                            }

                                            
                                            }

                                            function validateForm2() {
                                            var x = document.forms["myForm"]["admin_name"].value;
                                            if (x >0  || x != null) {
                                                document.getElementById("submit").disabled = false;
                                            
                                            }

                                            }
                                            </script>
                                         
                                       @if($ifexist[0]->admin_image)  
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="form-group{{ $errors->has('admin_image') ? ' has-error' : '' }}">
                                   
                                    <input type="file" name="admin_image" style="padding:3px 4px" class="form-control fileControl"  value="{{$ifexist[0]->admin_image}}"  onchange="loadPreview(this);">
                                   
                                    @if ($errors->has('admin_image'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('admin_image') }}</strong>
                                      </span>
                                  @endif
                                     </div>
                                  <label for="profile_image"></label> 
                                  <img id="preview_img" src="{{asset('public/uploads/admins/'.$ifexist[0]->admin_image)}}" width="200" height="150"/>
                                  <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
            
                                </div>
                                @else
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="form-group{{ $errors->has('admin_image') ? ' has-error' : '' }}">
                                   
                                    <input type="file" name="admin_image" style="padding:3px 4px" class="form-control fileControl"  value="{{$ifexist[0]->admin_image}}"  onchange="loadPreview(this);">
                                   
                                    @if ($errors->has('admin_image'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('admin_image') }}</strong>
                                      </span>
                                  @endif
                                     </div>
                                  <label for="profile_image"></label> 
                                  <img id="preview_img" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" width="200" height="150"/>
                                  <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
            
                                </div>
                                @endif
                               
                                <button type="submit" id="submit" class="btn btn-info">Submit</button>

                                <!-- <a href="{{url('/admin/categories')}}" class="btn btn-danger">Cancel</a> -->
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
        </section>

        </div>
        </div>
</section>


<script>
function remove2(){
  $('#preview_img').attr('src', 'http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png'); 
 
}
    </script>
@endsection