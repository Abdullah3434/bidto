@extends('admin.layout.apps')

@section('content')
<section id="main-content" class="">
    <section class="wrapper">
      
        <div class="row">
            <div class="col-md-3">
                <a href="{{url('/admin/items')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon orange"><i class="fa fa-gavel"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$count_item}}</span>
                            Total Posts
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{url('/admin/items')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon tar"><i class="fa fa-tag"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$count_active_items}}</span>
                            Active Posts
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{url('/admin/users')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon pink"><i class="fa fa-money"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$count_purchase}}</span>
                            Total Purchases
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{url('/admin/users')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon green"><i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$sum_top_up}}</span>
                            Total Top-up Amount
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <a href="{{url('/admin/users')}}">
                        <div class="mini-stat clearfix">
                            <span class="mini-stat-icon pink"><i class="fa fa-user"></i></span>
                            <div class="mini-stat-info">
                                <span>{{$count_all}}</span>
                                Total Users
                            </div>
                        </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{url('/admin/users')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon pink"><i class="fa fa-user"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$count_active}}</span>
                        Active Users
                        </div>
                    </div>
                </a>
            </div>
            

            <div class="col-md-3">
                <a href="{{url('/admin/items')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon pink"><i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$count_total_item}}</span>
                        Total Items
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{url('/admin/services')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon pink"><i class="fa fa-eye"></i></span>
                        <div class="mini-stat-info">
                            <span>{{$count_total_services}}</span>
                        Total Services
                        </div>
                    </div>
                </a>
            </div>
    
            <div class="col-md-3">
                <a href="{{url('/admin/requests')}}">
                    <div class="mini-stat clearfix">
                        <span class="mini-stat-icon pink"><i class="fa fa-tag"></i></span>
                            <div class="mini-stat-info">
                                <span>{{$count_total_requests}}</span>
                                    Total Requests
                            </div>
                
                    </div>
                </a>
            </div>

        </div>
                   
        <!--             
            <div class="col-lg-12">
                <section class="panel">
                   
                    <div class="panel-body">
                        <div class="position-center">
                 <h1> Welcome!. {{{ isset(Auth::user()->admin_name) ? Auth::user()->admin_name : Auth::user()->admin_email }}} </h1>
                 <h2> <strong>Dashboard, How's your day going </strong></h2>
                       
                </div>
                    </div>
                </section>

            </div>
        </div> -->
    
        <!-- page end-->
    </section>
   
</section>
@endsection
