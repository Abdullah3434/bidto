@extends('admin.layout.apps')

@section('content')

    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Service
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/service/'.$ifexist->id.'/'.$ifexist->item_type)}}" method="post" enctype="multipart/form-data" onclick="return validateForm()">
                                    @csrf
                                    <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Name </label>
                                    <div class="form-group{{ $errors->has('item_name') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm2()" id="text1" class="form-control" name="item_name" value="{{$ifexist->item_name}}" >
                                    
                                    @if ($errors->has('item_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_name') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                           
                      
                               


                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Promotion End Date </label>
                                    <div class="form-group{{ $errors->has('promotion_end_date') ? ' has-error' : '' }}"> 
                                    <input type="date"  class="form-control" name="promotion_end_date" value="{{ date('Y-m-d', strtotime($ifexist->promotion_end_date)) }}" >
                                    
                                    @if ($errors->has('promotion_end_date'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('promotion_end_date') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                           

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Is Promotion</label>
                                    <div class="form-group{{ $errors->has('is_promotion') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="is_promotion" >
                                        <option value="{{$ifexist->is_promotion}}">{{$ifexist->is_promotion}}</option>
                                           
                                           <option value="{{$is_promotion}}">{{$is_promotion}}</option>
                                            
                                        </select> 
                                    @if ($errors->has('is_promotion'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_promotion') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <!-- <div class="form-group" >
                                    <label for="exampleInputEmail1">Is Promoted</label>
                                    <div class="form-group{{ $errors->has('is_promoted') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="is_promoted" >
                                        <option value="{{$ifexist->is_promoted}}">{{$ifexist->is_promoted}}</option>
                                           
                                            <option value="{{$is_promoted}}">{{$is_promoted}}</option>
                                          
                                            
                                            
                                        </select> 
                                    @if ($errors->has('is_promoted'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('is_promoted') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div> -->


                            
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Location </label>
                                    <div class="form-group{{ $errors->has('item_location') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm2()" id="text1" class="form-control" name="item_location" value="{{$ifexist->item_location}}" >
                                    
                                    @if ($errors->has('item_location'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_location') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Latitude </label>
                                    <div class="form-group{{ $errors->has('item_latitude') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm2()" id="text1" class="form-control" name="item_latitude" value="{{$ifexist->item_latitude}}" readonly >
                                    
                                    @if ($errors->has('item_latitude'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_latitude') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Longitude </label>
                                    <div class="form-group{{ $errors->has('item_longitude') ? ' has-error' : '' }}">
                                    <input type="text" onchange="return validateForm2()" id="text1" class="form-control" name="item_longitude" value="{{$ifexist->item_longitude}}" readonly>
                                    
                                    @if ($errors->has('item_longitude'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_longitude') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                <label for="exampleInputEmail1">Item Description </label>
                                <div class="form-group{{ $errors->has('item_description') ? ' has-error' : '' }}">
                                <textarea class="form-control" name="item_description" value="{{$ifexist->item_description}}" rows="8" cols="5">{{$ifexist->item_description}}</textarea>
                                    
                                    @if ($errors->has('item_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_description') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>


                         
                             <script>
                                function validateForm() {
                                var x = document.forms["myForm"]["item_type"].value;
                                if (x == "" || x == null) {
                                    document.getElementById("submit").disabled = true;
                                
                                }
                                
                                }

                                function validateForm2() {
                                var x = document.forms["myForm"]["item_type"].value;
                                if (x >0  || x != null) {
                                    document.getElementById("submit").disabled = false;
                                
                                }

                                }
                                </script>
 
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
