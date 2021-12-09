@extends('admin.layout.apps')
@section('content')
    <section id="main-content" class="">
        <section class="wrapper">
      
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        View Chat 
                    </header>
                        <div class="panel-body">  
                            @if (\Session::has('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                        {!! \Session::get('success') !!}
                                </div>
                            @endif
                            <div class="position-center">
                    @foreach($ifexist as $sing_thread)
                        @if($sing_thread->from_id==$from_id)
                    <div class="row msg_container base_sent" data-message-id="" >
                        <div class="col-md-10 col-xs-10" >
                            <!-- <div style="text-align:right">
                                <a href="" class="fas fa-trash-alt " title="Delete" data-toggle="modal" data-target="#exampleModal{{$sing_thread->id}}" style="color:red">  </a>
                            ​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​​
                            </div> -->
                            <div class="messages msg_sent text-right">
                            
                                <p>
                                    <a href="" class="fas fa-trash-alt" title="Delete" data-toggle="modal" data-target="#exampleModal{{$sing_thread->id}}" style="color:red;float:left;">  </a>
                                     <br>{{$sing_thread->message}}<br>
                                </p>
                            </div>
                            
                                </div>
                                    <div class="col-md-2 col-xs-2 avatar">
                                        <img src="{{$ifexist[0]->sender['thumb_image']}}" width="100" height="50" class="img-responsive" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">
                                        <span class="time_date" style="font-size: 9px;"> {{date_format($sing_thread->created_at,"d-m-Y H:i:s")}}</span>
                                    </div>
                                
                                </div>
                        @endif
                            <div class="modal fade" id="exampleModal{{$sing_thread->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                            <div class="modal-body">
                                                Are you sure to delete this?
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <a href="{{url('/admin/delete/chat/'.$sing_thread->id)}}" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                         
                           
                            @if($sing_thread->from_id!=$from_id)
                                <div class="row msg_container base_receive" data-message-id="">
                                    <div class="col-md-2 col-xs-2 avatar">
                                
                                    <img src="{{$ifexist[0]->receiver['thumb_image']}}"  width="100" height="50" class=" img-responsive" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">
                                    <span class="time_date"  style="font-size: 9px;"> {{date_format($sing_thread->created_at,"d-m-Y H:i:s")}}</span>   
                                    
                                        </div>
                                    <div class="col-md-10 col-xs-10">
                                    
                                        <div class="messages msg_receive text-left">
                                            <p>
                                                <a href="" class="fas fa-trash-alt" title="Delete" data-toggle="modal" data-target="#exampleModal{{$sing_thread->id}}" style="color:red;float:right;">  </a>
                                                <br>
                                                {{$sing_thread->message}} <br>
                                            </p>
                                        </div>
                                            
                                    </div>
                                </div>
                            @endif
                            <div class="modal fade" id="exampleModal{{$sing_thread->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                      <div class="modal-body">
                                      Are you sure to delete this?
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a href="{{url('/admin/delete/chat/'.$sing_thread->id)}}" class="btn btn-danger">Delete</a>
                                      </div>
                                    </div>
                                </div>
                            </div>
                    @endforeach
            
                            </div>

                        </div>
                    </section>

                </div>
           
            </section>

        </div>
    </div>


    </section>

@endsection
