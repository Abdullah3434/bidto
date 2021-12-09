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
                            Edit Item Type
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">

                                {!! \Session::get('success') !!}

                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/item-types/'.$ifexist[0]->type_key)}}" method="post" enctype="multipart/form-data"  onchange="return validateForm()">
                                    @csrf

                                    @foreach($language as $single_language)
                                       
                                        @foreach($ifexist as $sing_type)
                                            @if($sing_type->lang_key==$single_language->lang_key)
                                                @php
                                                $type_name = $sing_type->type_name;
                                                @endphp
                                              
                                            @endif
                                        @endforeach
 
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Name in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('type_name_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                            
                                            <input type="text"  oninput="return validateForm2()"  class="form-control" name="type_name_{{$single_language->lang_key}}" value="{{$type_name}}">
                                          
                                            @if ($errors->has('type_name_'.$single_language->lang_key))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('type_name_'.$single_language->lang_key) }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                        </div>
                                        <script>
                                            function validateForm() {
                                                var x = document.forms["myForm"]["type_name_{{$single_language->lang_key}}"].value;
                                                if (x == "" || x == null) {
                                                    document.getElementById("submit").disabled = true;
                                                
                                                }

                                                
                                                }

                                                function validateForm2() {
                                                var x = document.forms["myForm"]["type_name_{{$single_language->lang_key}}"].value;
                                                if (x >0  || x != null) {
                                                    document.getElementById("submit").disabled = false;
                                                
                                                }

                                                }
                                            </script>
                                        @endforeach
                           
                        
                               
                                        <button type="submit" id="submit" class="btn btn-info">Submit</button>

                                        <a href="{{url('/admin/item-types')}}" class="btn btn-danger">Cancel</a>
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