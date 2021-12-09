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
                            <th>Name</th>
                            <th>Card Number</th>
                            <th>Card CVV</th>
                            <th>Card Expiry</th>
                            <th>Status</th>
                            <th >Action</th>
                        </tr>
                      </thead> 
                        <tbody> 
                          @foreach($ifexist as $single_model)
                            <tr>
                      @php 
                      $rest = substr($single_model->card_number,-4);
                      @endphp
                              <td>{{$single_model->card_holder_name}}</td>
                              <td>*****{{$rest}}</td>
                              <td>****</td>
                        

                              <td>{{$single_model->card_expiry}}</td>
                              <td >@if($single_model->status=='active')
                              <span class="label label-primary" style="background-color: #28a745;"><a href="{{url('/admin/user/card/status/'.$single_model->status.'/'.$single_model->id)}}">Active</a></span>
                              @else
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href="{{url('/admin/user/card/status/'.$single_model->status.'/'.$single_model->id)}}">In Active</a></span>
                              @endif
                             

                              <td> <a href="{{url('/admin/card/edit/'.$single_model->id.'/'.$single_model->user_id)}}"><i class="fas fa-edit"></i></a> 
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
                                      <a href="{{url('/admin/delete/card/'.$single_model->id)}}" class="btn btn-danger">Delete</a>
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
