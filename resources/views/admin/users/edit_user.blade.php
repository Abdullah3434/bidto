@extends('admin.layout.apps')

@section('content')
    <section id="main-content" class="">
        <section class="wrapper">
        <div class="row">
            <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit User
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {!! \Session::get('success') !!}
                                </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/edit/user/'.$ifexist->id)}}" method="post" enctype="multipart/form-data"  >
                                    @csrf

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">User Name</label>
                                            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                                                @if($ifexist->user_name)
                                                    <input type="text"  class="form-control" name="user_name" value="{{$ifexist->user_name}}">
                                                @else
                                                    <input type="text"  class="form-control" name="user_name" value="{{ old('user_name') }}">
                                                @endif
                                                @if ($errors->has('user_name'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">User Email</label>
                                            <div class="form-group{{ $errors->has('user_email') ? ' has-error' : '' }}">
                                            
                                            <input type="text"  class="form-control" name="user_email" value="{{$ifexist->user_email}}" >
                                            @if ($errors->has('user_email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('user_email') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">User Phone</label>
                                            <div class="form-group{{ $errors->has('user_phone') ? ' has-error' : '' }}">
                                                @if($ifexist->user_phone)
                                                    <input type="text"   class="form-control" name="user_phone" value="{{$ifexist->user_phone}}">
                                                @else
                                                    <input type="text"  class="form-control" name="user_phone" value="{{ old('user_phone') }}">
                                                @endif
                                           
                                                @if ($errors->has('user_phone'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('user_phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Language Key</label>
                                                <div class="form-group{{ $errors->has('lang_key') ? ' has-error' : '' }}">
                                            
                                                    <select  class="form-control" name="lang_key">
                                                   
                                                        <option value="{{$lang_keys[0]->lang_key}}">{{$lang_keys[0]->lang_key}}</option>
                                                        
                                                        <option value="{{$lang_key}}">{{$lang_key}}</option>
                                                      
                                                    </select>
                                                        @if ($errors->has('lang_key'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('lang_key') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">User Balance</label>   
                                            <input type="text"   class="form-control" name="user_balance" value="{{$ifexist->user_balance}}" readonly>   
                                        </div>
                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">User Promotion Ads</label>
                                           <input type="text"  class="form-control" name="promotion_ads" value="{{$ifexist->promotion_ads}}" readonly>
                                           
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputFile">Image</label>
                                            <div class="form-group{{ $errors->has('user_image') ? ' has-error' : '' }}">
                                                <input type="file" name="user_image" style="padding:3px 4px" class="form-control fileControl"  value="{{$ifexist->user_image}}"  onchange="loadPreview(this);">
                                            
                                                        @if ($errors->has('user_image'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('user_image') }}</strong>
                                                            </span>
                                                        @endif
                                            </div>
                                            <label for="profile_image"></label> 
                                         
                                            <img id="preview_img" src="{{asset('public/uploads/'.$ifexist->user_image)}}" width="200" height="150" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';"/>
                                           
                                            <button type="button" class="btn btn-danger" onClick="remove2();">Remove</button>
                    
                                        </div> 
         
                                        <button type="submit" class="btn btn-info">Submit</button>
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
@section('scripts')
<script>
function remove2(){
  $('#preview_img').attr('src', 'http://w3adda.com/wp-content/uploads/2019/09/No_Image-128.png'); 
  $(".fileControl").val('');
}
    </script>
@stop 