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
                            Add Category
                        </header>
                            <div class="panel-body">
                                
                                @if (\Session::has('success'))
                                        <div class="alert alert-success">

                                        {!! \Session::get('success') !!}

                                        </div>
                                @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/add/category')}}" method="post" enctype="multipart/form-data" >
                                    @csrf


                                    @foreach($language as $single_language)
                                    
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Name in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('cat_name_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                                <input type="text"   class="form-control " name="cat_name_{{$single_language->lang_key}}" placeholder="Name in {{$single_language->lang_name}}" value="{{ old('cat_name_'.$single_language->lang_key) }}">
                                               
                                                @if ($errors->has('cat_name_{{$single_language->lang_key}}'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cat_name_'.$single_language->lang_key) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                           
                                    @endforeach
                               
                           
                                <div class="form-group">
                                    <label for="exampleInputFile">Image</label>
                                    <div class="form-group{{ $errors->has('cat_image') ? ' has-error' : '' }}">
                                    <input type="file"  name="cat_image" style="padding:3px 4px" class="form-control fileControl"    onchange="loadPreview(this);">

                                    @if ($errors->has('cat_image'))
                                      <span class="help-block">
                                          <strong>{{ $errors->first('cat_image') }}</strong>
                                      </span>
                                  @endif
                                    </div>

                        <label for="profile_image"></label>
                        <img id="preview_img" src="http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png" class="" width="200" height="150"/>
                        <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
                     
                                </div>
                               
                        <button type="submit"  class="btn btn-info " style="margin-top:10px">Submit</button>
                            </form>
                            </div>

                        </div>
                    </section>

            </div>
           
        </section>

    </div>
</div>
                <script>
                    function remove2(){
                    $('#preview_img').attr('src', 'http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png'); 
                    $(".fileControl").val('');
                    }
                </script>
            

</section>

@endsection


