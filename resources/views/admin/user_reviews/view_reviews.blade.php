@extends('admin.layout.apps')
@section('content')
<section id="container" >

  <section id="main-content">
    <section class="wrapper">
    <!-- page start-->

      <div class="row">
        <div class="col-sm-12">
            <section class="panel">
            
                <div class="panel-body">
                  @if (\Session::has('success'))
                    <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                            {!! \Session::get('success') !!}
                        
                    </div>
                  @endif
                 
                    <table  id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                            <th>From Name</th>
                            <th>To Name</th>
                            <th>Review</th>
                            <th>Rating</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th >Action</th>
                        </tr>
                      </thead>
                        <tbody>
                          @foreach($ifexist as $single_model)
                            @php 
                                    $from= $single_model->from_id;
                                    $to= $single_model->to_id;
                                   if(( $single_model->from_id)>0)
                                   
                                    $from_name = \App\Models\User::find($from);

                                    else
                                    $from_name="";
                                    $to_name = \App\Models\User::find($to);
                                   
                                
                            @endphp
                            <tr>
                              
                            <td>{{$from_name->user_name}}</td>
                            <td>{{$to_name->user_name}}</td>
                              <td>{{$single_model->comment}}</td>
                              <td>{{$single_model->rating}}</td>
                              <td>{{date_format($single_model->created_at,"d-m-Y H:i:s")}}</td>
                              
                              <td >@if($single_model->status=='active')
                              <span class="label label-primary" style="background-color: #28a745;"><a href="{{url('/admin/user/reviews/status/'.$single_model->status.'/'.$single_model->id)}}">Active</a></span>
                              @else
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href="{{url('/admin/user/reviews/status/'.$single_model->status.'/'.$single_model->id)}}">In Active</a></span>
                              @endif
                             

                              <td> <a href="{{url('/admin/reviews/edit/'.$single_model->id.'/'.$single_model->to_id)}}"><i class="fas fa-edit"></i></a> 
                              <a href="" class="fas fa-trash-alt" data-toggle="modal" data-target="#exampleModal{{$single_model->id}}"></a></td>
                            </tr>



                              <div class="modal fade" id="exampleModal{{$single_model->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                      <a href="{{url('/admin/delete/reviews/'.$single_model->id)}}" class="btn btn-danger">Delete</a>
                                    </div>
                                  </div>
                                </div>
                              </div>

                          @endforeach

                        </tbody>
        
                      </table>
                   
                  </div>
            </section>
        </div>
      </div>
   
    </section>
  </section>
</section>

@endsection
