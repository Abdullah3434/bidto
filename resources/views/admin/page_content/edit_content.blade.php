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
                            Edit Page Content
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                            <div class="alert alert-success">

                            {!! \Session::get('success') !!}

                            </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/content/'.$ifexist[0]->page_key)}}" method="post" enctype="multipart/form-data"  onchange="return validateForm()">
                                    @csrf


                          

                                    @foreach($language as $single_language)
                                       
                                        @foreach($ifexist as $sing_content)
                                            @if($sing_content->lang_key==$single_language->lang_key)
                                                @php
                                                    $page_name = $sing_content->page_name;
                                                    $page_content = $sing_content->page_content;
                                                    $meta_title = $sing_content->meta_title;
                                                    $meta_keywords = $sing_content->meta_keywords;
                                                    $meta_description = $sing_content->meta_description;
                                                @endphp
                                              
                                            @endif
                                        @endforeach
 
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Page Name in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('page_name_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                            
                                            <input type="text"  oninput="return validateForm2()"  class="form-control" name="page_name_{{$single_language->lang_key}}" value="{{$page_name}}">
                                            @if ($errors->has('page_name_{{$single_language->lang_key}}'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('page_name_'.$single_language->lang_key) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        @foreach($language as $single_language)
                                       
                                       @foreach($ifexist as $sing_content)
                                           @if($sing_content->lang_key==$single_language->lang_key)
                                          @php
                                             
                                              $meta_title = $sing_content->meta_title;
                                              $meta_keywords = $sing_content->meta_keywords;
                                              $meta_description = $sing_content->meta_description;
                                          @endphp
                                        
                                      @endif
                                  @endforeach
                                   <div class="form-group" >
                                       <label for="exampleInputEmail1">Meta Title in {{$single_language->lang_name}}</label>
                                       <div class="form-group{{ $errors->has('meta_title_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                       
                                       <input type="text"  oninput="return validateForm2()"  class="form-control" name="meta_title_{{$single_language->lang_key}}" value="{{$meta_title}}">
                                       @if ($errors->has('meta_title_{{$single_language->lang_key}}'))
                                           <span class="help-block">
                                               <strong>{{ $errors->first('meta_title_'.$single_language->lang_key) }}</strong>
                                           </span>
                                           @endif
                                       </div>
                                   </div>
                                   @endforeach
                                       
                                       
                                        @foreach($language as $single_language)
                                       
                                       @foreach($ifexist as $sing_content)
                                           @if($sing_content->lang_key==$single_language->lang_key)
                                          @php
                                            
                                              $meta_keywords = $sing_content->meta_keywords;
                                              $meta_description = $sing_content->meta_description;
                                          @endphp
                                        
                                      @endif
                                  @endforeach
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Meta Keyword in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('meta_keyword_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                            
                                            <input type="text"  oninput="return validateForm2()"  class="form-control" name="meta_keyword_{{$single_language->lang_key}}" value="{{$meta_keywords}}">
                                            @if ($errors->has('meta_keyword_{{$single_language->lang_key}}'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('meta_keyword_'.$single_language->lang_key) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        @foreach($language as $single_language)
                                       
                                       @foreach($ifexist as $sing_content)
                                           @if($sing_content->lang_key==$single_language->lang_key)
                                          @php
                                            
                                              $meta_description = $sing_content->meta_description;
                                          @endphp
                                        
                                      @endif
                                  @endforeach
                                        <div class="form-group op" >
                                            <label for="exampleInputEmail1">Meta Description in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('meta_description_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                           
                                            <textarea   oninput="return validateForm2()"  class="form-control" name="meta_description_{{$single_language->lang_key}}" rows="9" cols="50">{{$meta_description}}</textarea>
                                            @if ($errors->has('meta_description_{{$single_language->lang_key}}'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('meta_description_'.$single_language->lang_key) }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                      
                                        <script>
                                        function validateForm() {
                                            var x = document.forms["myForm"]["page_name_{{$single_language->lang_key}}"].value;
                                            if (x == "" || x == null) {
                                                document.getElementById("submit").disabled = true;
                                            }}

                                            function validateForm2() {
                                            var x = document.forms["myForm"]["cat_name_{{$single_language->lang_key}}"].value;
                                            if (x >0  || x != null) {
                                                document.getElementById("submit").disabled = false;
                                            
                                            }}
                                            </script>
                                           @endforeach
                           
                                           @foreach($language as $single_language)
                                       
                                       @foreach($ifexist as $sing_content)
                                           @if($sing_content->lang_key==$single_language->lang_key)
                                          @php
                                             
                                              $page_content = $sing_content->page_content;
                                              $meta_title = $sing_content->meta_title;
                                              $meta_keywords = $sing_content->meta_keywords;
                                              $meta_description = $sing_content->meta_description;
                                          @endphp
                                        
                                      @endif
                                  @endforeach
                                   <div class="form-group" >
                                       <label for="exampleInputEmail1">Page Content in {{$single_language->lang_name}}</label>
                                       <div class="form-group{{ $errors->has('page_content_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                       <textarea id="editor2_{{$single_language->lang_key}}"  class="form-control" name="page_content_{{$single_language->lang_key}}"   rows="4" cols="50">{{$page_content}}</textarea>
                                       
                                       @if ($errors->has('page_content_{{$single_language->lang_key}}'))
                                           <span class="help-block">
                                               <strong>{{ $errors->first('page_content_'.$single_language->lang_key) }}</strong>
                                           </span>
                                           @endif
                                       </div>
                                   </div>

                                   <script>
                                           ClassicEditor
                                           .create( document.querySelector( '#editor2_{{$single_language->lang_key}}' ) )


                                   </script>

                                   @endforeach
                               
                               
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



@endsection