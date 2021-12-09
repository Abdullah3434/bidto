@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Cylinder
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                            <div class="alert alert-success">
                            
                                    {!! \Session::get('success') !!}
                                
                            </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/cylinder/'.$ifexist->id)}}" method="post" enctype="multipart/form-data" >
                                    @csrf
    
                                    <div class="form-group" >
                                        <label for="exampleInputEmail1">Cylinder Name </label>
                                        <div class="form-group{{ $errors->has('condition_name') ? ' has-error' : '' }}">
                                            <input type="text"  class="form-control" name="cylinder_name" value="{{$ifexist->item_cylinder}}">
                                        
                                                @if ($errors->has('cylinder_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('cylinder_name') }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>
                                 
                                    <input type="submit" class="btn btn-info" style="margin-top:10px">
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
