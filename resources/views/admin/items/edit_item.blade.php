@extends('admin.layout.apps')
@section('content')
    <section id="main-content" class="">
        <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Item
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                
                                        {!! \Session::get('success') !!}
                                    
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/item/'.$ifexist->id.'/'.$ifexist->item_type)}}" method="post" enctype="multipart/form-data">
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
                            @if($ifexist->item_type=='item')
                                    <div class="form-group" >
                                    <label for="exampleInputEmail1">Category </label>
                                    <div class="form-group{{ $errors->has('category_key') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="category_key" >
                                            <option value="{{$find_cat}}">{{$find_cat}}</option>
                                            @foreach($all_cat as $single_cat)
                                            <option value="{{$single_cat->cat_key}}">{{$single_cat->cat_key}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('category_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category_key') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Make</label>
                                    <div class="form-group{{ $errors->has('item_make_id') ? ' has-error' : '' }}">
                                    
                                        <select class="form-control" name="item_make_id" id="item_make_id">
                                            <option value="{{urlencode($find_make_id)}}">{{$find_makee}}</option>
                                            @foreach($all_make as $single_make)
                                            <option value="{{urlencode($single_make->id)}}">{{$single_make->make_name}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_make_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_make_id') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div> 
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Model </label>
                                    <div class="form-group{{ $errors->has('item_model_id') ? ' has-error' : '' }}">
                                    <select name="item_model_id" class="form-control" id="item_model_id" >
                                    <option value="{{$find_model_id}}" >{{$find_model_name}}</option>
                                    @foreach($all_model as $single_model)
                                            <option value="{{$single_model->id}}">{{$single_model->model_name}}</option>
                                            @endforeach
                                     </select>
                                       
                                    </div>
                                </div>


                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Condition </label>
                                    <div class="form-group{{ $errors->has('item_condition_id') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="item_condition_id" >
                                            <option value="{{$find_condition_id}}">{{$find_condition_name}}</option>
                                            @foreach($all_condition as $single_condition)
                                            <option value="{{$single_condition->id}}">{{$single_condition->condition_name}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_condition_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_condition_id') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Cylinder </label>
                                    <div class="form-group{{ $errors->has('item_cylinder_id') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="item_cylinder_id" >
                                            <option value="{{$find_cylinder_id}}">{{$find_cylinder_name}}</option>
                                            @foreach($all_cylinder as $single_cylinder)
                                            <option value="{{$single_cylinder->id}}">{{$single_cylinder->item_cylinder}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_cylinder_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_cylinder_id') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Transmission </label>
                                    <div class="form-group{{ $errors->has('item_transmission_id') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="item_transmission_id" >
                                            <option value="{{$find_trans_id}}">{{$find_trans_name}}</option>
                                            @foreach($all_trans as $single_trans)
                                            <option value="{{$single_trans->id}}">{{$single_trans->transmission_name}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_transmission_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_transmission_id') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Type Key</label>
                                    <div class="form-group{{ $errors->has('item_type_key') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="item_type_key" >
                                            <option value="{{$find_type}}">{{$find_type}}</option>
                                            @foreach($all_type as $single_type)
                                            <option value="{{$single_type->type_key}}">{{$single_type->type_key}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_type_key'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_type_key') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>


                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Interior Color </label>
                                    <div class="form-group{{ $errors->has('item_interior_color_id') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="item_interior_color_id" >
                                            <option value="{{$find_interior_color_id}}">{{$find_interior_color_name}}</option>
                                            @foreach($all_color_interior as $single_color_interior)
                                            <option value="{{$single_color_interior->id}}">{{$single_color_interior->color_name}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_interior_color_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_interior_color_id') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Exterior Color </label>
                                    <div class="form-group{{ $errors->has('item_exterior_color_id') ? ' has-error' : '' }}">
                                    
                                        <select onchange="return validateForm2()" id="text1" class="form-control" name="item_exterior_color_id" >
                                            <option value="{{$find_exterior_color_id}}">{{$find_exterior_color_name}}</option>
                                            @foreach($all_color_exterior as $single_color_exterior)
                                            <option value="{{$single_color_exterior->id}}">{{$single_color_exterior->color_name}}</option>
                                            @endforeach
                                        </select> 
                                    @if ($errors->has('item_exterior_color_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_exterior_color_id') }}</strong>
                                        </span>
                                    @endif
                                    </div> 
                                </div>
                            @endif
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


                            
                                @if($ifexist->item_type=='item')
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Max Price </label>
                                    <div class="form-group{{ $errors->has('item_to_price') ? ' has-error' : '' }}">
                                    <input type="number" onchange="return validateForm2()" id="text1" class="form-control" name="item_to_price" value="{{$ifexist->item_to_price}}" >
                                    
                                    @if ($errors->has('item_to_price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_to_price') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                @endif
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


                            @if($ifexist->item_type=='item')
                                <div class="form-group" >
                                    <label for="exampleInputEmail1">Item Year </label>
                                    <div class="form-group{{ $errors->has('item_year') ? ' has-error' : '' }}">
                                    <input type="number" onchange="return validateForm2()" id="text1" class="form-control" name="item_year" value="{{$ifexist->item_year}}" >
                                    
                                    @if ($errors->has('item_year'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_year') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                                @endif
                         
                                <div class="form-group" >
                                <label for="exampleInputEmail1">Item Description </label>
                                <div class="form-group{{ $errors->has('item_description') ? ' has-error' : '' }}">
                                <textarea  class="form-control" name="item_description" value="{{$ifexist->item_description}}" rows="8" cols="5">{{$ifexist->item_description}}</textarea>
                                    
                                    @if ($errors->has('item_description'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('item_description') }}</strong>
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
