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
                            Edit Category
                        </header>
                            <div class="panel-body">
                              
                                @if (\Session::has('success'))
                                    <div class="alert alert-success">

                                {!! \Session::get('success') !!}
                                @endif
                            </div>
                               
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/category/'.$ifexist[0]->cat_key)}}" method="post" enctype="multipart/form-data"  >
                                    @csrf

                                    @foreach($language as $single_language)
                                       
                                        @foreach($ifexist as $sing_cat)
                                            @if($sing_cat->lang_key==$single_language->lang_key)
                                                @php
                                                    $cat_name = $sing_cat->cat_name;
                                                @endphp
                                              
                                            @endif
                                        @endforeach
 
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Name in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('cat_name_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                            
                                            <input type="text"  class="form-control" name="cat_name_{{$single_language->lang_key}}" value="{{$cat_name}}">
                                            @if ($errors->has('cat_name_'.$single_language->lang_key))
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
                                   
                                            <input type="file" name="cat_image" style="padding:3px 4px" class="form-control fileControl"  value="{{$ifexist[0]->cat_image}}"  onchange="loadPreview(this);" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">
                                    
                                                @if ($errors->has('cat_image'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cat_image') }}</strong>
                                                </span>
                                                @endif
                                        </div>
                                    <label for="profile_image"></label> 
                                    <img id="preview_img" src="{{asset('public/uploads/categories/thumbs/'.$ifexist[0]->cat_image)}}" width="200" height="150" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';"/>
                                    <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
            
                                </div> 
                               
                                <button type="submit" id="submit" class="btn btn-info">Submit</button>

                                <a href="{{url('/admin/categories')}}" class="btn btn-danger">Cancel</a>
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
@section('scripts')
<script>
function remove2(){
  $('#preview_img').attr('src', 'http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png'); 
  $(".fileControl").val('');
}
    </script>
@stop 