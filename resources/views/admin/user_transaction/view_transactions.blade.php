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
                            <th>Transaction Type</th>
                            <th>Blance</th>
                            <th>Date</th>
                            <th >Action</th>
                        </tr>
                      </thead>
                        <tbody>
                          @foreach($ifexist as $single_model)
                            <tr>
                            
                              <td>
                                @if($single_model->transaction_type=='add_balance')
                                  Deposit Funds For Top-up Account
                                @else
                                  Fee for Promotion Package
                                @endif

                              </td>
                              <td >@if($single_model->transaction_type=='add_balance')
                              <span style="color:green">+</span> {{$single_model->amount}}
                              @else
                              <span style="color:red">-</span> {{$single_model->amount}}</td>
                              @endif 
                              <td>{{date_format($single_model->created_at,"d-m-Y H:i:s")}}</td>
                             
                              <td> <a href="{{url('/admin/transactions/edit/'.$single_model->id.'/'.$single_model->user_id)}}"><i class="fas fa-edit"></i></a> 
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
                                      <a href="{{url('/admin/delete/transaction/'.$single_model->id)}}" class="btn btn-danger">Delete</a>
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
