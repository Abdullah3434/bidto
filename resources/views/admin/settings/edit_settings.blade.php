@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Settings
                        </header>
                            <div class="panel-body">
                              
                                @if (\Session::has('success'))
                                    <div class="alert alert-success">
                                    
                                            {!! \Session::get('success') !!}
                                        
                                    </div>
                                @endif
                                <div class="position-center">
                                    @foreach($all_settings as $single_setting)
                                    <form name="myForm" action="{{url('/admin/edit/setting')}}" method="post" enctype="multipart/form-data" >
                                    @csrf

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">{{ucwords(str_replace('_',' ', $single_setting->key))}}</label>
                                            <div class="form-group{{ $errors->has('setting') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control " name="{{$single_setting->key}}" value="{{$single_setting->value}}">
                                           
                                            @if ($errors->has('setting'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('setting') }}</strong>
                                                </span>
                                            @endif
                                            </div>
                                        </div>

                                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
                                        <script>

                                        $(document).ready(function() {
                                        validate();
                                        $('input').on('keyup', validate);
                                        });

                                        function validate() {
                                        var inputsWithValues = 0;
                                        
                                        // get all input fields except for type='submit'
                                        var myInputs = $("input:not([type='submit'])");

                                        myInputs.each(function(e) {
                                            // if it has a value, increment the counter
                                            if ($(this).val()) {
                                            inputsWithValues += 1;
                                            }
                                        });

                                        if (inputsWithValues == myInputs.length) {
                                            $("input[type=submit]").prop("disabled", false);
                                        } else {
                                            $("input[type=submit]").prop("disabled", true);
                                        }
                                        }
                                            </script>
                                        

                                    @endforeach
                           
       
                                        <input type="submit"class="btn btn-info " style="margin-top:10px">
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
