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
                            Edit Bid
                        </header>
                        <div class="panel-body">
                              
                            @if (\Session::has('success'))
                            <div class="alert alert-success">

                            {!! \Session::get('success') !!}

                            </div>
                            @endif
                            <div class="position-center">
                                <form name="myForm" action="{{url('/admin/request/edit/bid/'.$ifexist->id.'/'.$item[0]->id)}}" method="post" enctype="multipart/form-data" >
                                    @csrf

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">User Name</label>
                                            <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                                            
                                            <input type="text" class="form-control" name="user_name" value="{{$user[0]->user_name}}" readonly>
                                            @if ($errors->has('user_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('user_name') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Post</label>
                                            <div class="form-group{{ $errors->has('item_id') ? ' has-error' : '' }}">
                                            
                                            <input type="text" class="form-control" name="item_id" value="{{$item[0]->item_name}}"  readonly >
                                            @if ($errors->has('item_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('item_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group" >
                                            <label for="exampleInputEmail1">Bid Amount</label>
                                            <div class="form-group{{ $errors->has('bid_amount') ? ' has-error' : '' }}">
                                            
                                            <input type="number" class="form-control" name="bid_amount" value="{{$ifexist->bid_amount}}">
                                            @if ($errors->has('bid_amount'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('bid_amount') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                         
                
                                <input type="submit" class="btn btn-info">

                                <!-- <a href="{{url('/admin/categories')}}" class="btn btn-danger">Cancel</a> -->
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