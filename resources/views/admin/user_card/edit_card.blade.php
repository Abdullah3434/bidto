@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Card
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/card/'.$ifexist->id.'/'.$user_id)}}" method="post" enctype="multipart/form-data" >
                                    @csrf
 
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Card Holder Name </label>
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    @if($ifexist->card_holder_name)
                                    <input type="text"  id="text1" class="form-control" name="name" value="{{$ifexist->card_holder_name}}" >
                                   @else
                                            <input type="text"  class="form-control" name="name" value="{{ old('name') }}">
                                            @endif
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                           
                            <div class="form-group" >
                                <label for="exampleInputEmail1">Card Number </label>
                                <div class="form-group{{ $errors->has('card_number') ? ' has-error' : '' }}"> 
                                <input type="text"  id="text1" class="form-control" name="card_number" value="*****{{substr($ifexist->card_number,-4)}}">
                                <input type="hidden"  class="form-control" name="card_number2" value="{{$ifexist->card_number}}">
                                   
                                    @if ($errors->has('card_number'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('card_number') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group" >
                                <label for="exampleInputEmail1">Card CVV </label>
                                <div class="form-group{{ $errors->has('card_cvv') ? ' has-error' : '' }}">
                                <input type="text" id="text1" class="form-control" name="card_cvv" value="***{{substr($ifexist->card_cvv,-1)}}">
                                <input type="hidden"  name="card_cvv2" value="{{$ifexist->card_cvv}}">
                                    
                                    @if ($errors->has('card_cvv'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('card_cvv') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                              
                            <div class="form-group" >
                                <label for="exampleInputEmail1">Card Expiry  </label>
                               

                                <div class="form-group{{ $errors->has('card_expiry') ? ' has-error' : '' }}">
                                <input type="month" data-format="m-y"  class="form-control" name="card_expiry" value="{{$ifexist->card_expiry}}"> 
                                    
                                    @if ($errors->has('card_expiry'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('card_expiry') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                         
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
