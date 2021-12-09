@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Message Templates   
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/message-temp/'.$ifexist->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
 
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Message Name </label>
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input type="text" class="form-control" name="name" value="{{$ifexist->name}}">
                                    
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                              

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Message Content </label>
                                    <div class="form-group{{ $errors->has('message_template') ? ' has-error' : '' }}">
                                    <textarea  name="message_template"   rows="8" cols="50" class="form-control" > {{$ifexist->message_template}}</textarea>
                                    <p> please do not change text in {}. </p>
                                    @if ($errors->has('message_template'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('message_template') }}</strong>
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
