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
                            Add Item Type
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/add/item_type')}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf


                                    @foreach($language as $single_language)
                                    
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Name in {{$single_language->lang_name}}</label>
                                            <div class="form-group{{ $errors->has('type_name_'.$single_language->lang_key) ? ' has-error' : '' }}">
                                                <input type="text" oninput="return validateForm2()" id="text1" class="form-control" name="type_name_{{$single_language->lang_key}}" placeholder="Name in {{$single_language->lang_name}}" value="{{ old('type_name_'.$single_language->lang_key) }}">
                                                <!-- <input type="hidden" class="form-control"  name="names[]" value="en"> -->
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
