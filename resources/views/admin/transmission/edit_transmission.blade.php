@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Transmission
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/transmission/'.$ifexist->id)}}" method="post" enctype="multipart/form-data" >
                                    @csrf


                                   
                                    
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">transmission Name </label>
                                    <div class="form-group{{ $errors->has('transmission_name') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control " name="transmission_name" value="{{$ifexist->transmission_name}}">
                                    
                                    @if ($errors->has('transmission_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('transmission_name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
              
    
                                    <input type="submit"  class="btn btn-info" style="margin-top:10px">
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
