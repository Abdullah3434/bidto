@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Item Models
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/add/item/model/'.$make_id)}}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                        @foreach($all_makes as $single_make)

                                            @if($single_make->id==$make_id)
                                                @php
                                                $make_name = $single_make->make_name;
                                                @endphp
                                                
                                            @endif

                                        @endforeach   
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Item Make Name </label>
                                            <div class="form-group{{ $errors->has('make_name') ? ' has-error' : '' }}">
                                                <input type="text" class="form-control" name="make_name" value="{{$make_name}}" readonly>
                                                
                                                @if ($errors->has('make_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('make_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Item Model Name </label>
                                            <div class="form-group{{ $errors->has('model_name') ? ' has-error' : '' }}">
                                                <input type="text" class="form-control " name="model_name" placeholder="Model Name" value="{{ old('model_name') }}">
                                                
                                                @if ($errors->has('model_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('model_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

           
                
                                    <input type="submit" class="btn btn-info " style="margin-top:10px">
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
