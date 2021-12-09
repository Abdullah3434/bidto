@extends('admin.layout.apps')
@section('content')
<section id="container" >

  <section id="main-content">
    <section class="wrapper">
    <!-- page start-->
    <h2><b>  View Bids </b>  </h2>
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
                            <th>User Name</th>
                            <th>Item Name</th>
                            <th> Amout</th>
                            <th>Status</th>
                            <th >Action</th>
                        </tr>
                      </thead> 
                        <tbody> 
                          @foreach($all_bids as $single_item)
                            <tr>
                                @php 
                                    $user= $single_item->user_id;
                                    $item= $single_item->item_id;
                          
                                    $user_name = \App\Models\User::find($user);
                                    $item_name = \App\Models\Item::find($item);
                                
                                @endphp
                                @if(($user_name))
                              <td>{{$user_name->user_name}}</td>
                              @else
                              <td></td>
                              @endif
                              <td>{{$item_name->item_name}}</td>
                              <td>{{$single_item->bid_amount}}</td>
                              <td >@if($single_item->status=='approved')
                              <span class="label label-primary" style="background-color: #28a745;">
                                <a href=""  data-toggle="modal" data-target="#exampleModal{{$single_item->id}}">Approved</a></span>
                              @elseif($single_item->status=='not_approved')
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href=""  data-toggle="modal" data-target="#exampleModal{{$single_item->id}}">Not Approved</a></span>
                              @else
                              <span class="label label-warning" style="background-color:#ffc107;"><a href=""  data-toggle="modal" data-target="#exampleModal{{$single_item->id}}">Pending</a></span>
                             
                              @endif
                             

                              <td> 
                              <a href="{{url('/admin/request/bids/edit/'.$single_item->id)}}" class="fas fa-edit"    title="Edit"></a>
                                <a href="" class="fas fa-trash-alt"  data-toggle="modal" data-target="#exampleModal2{{$single_item->id}}" title="Delete"></a>
                              </td>
                            </tr>



                              <div class="modal fade" id="exampleModal{{$single_item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                  <form name="myForm" action="{{url('/admin/request/update/bid/status/'.$single_item->id)}}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Confirmation </h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                    <label for="status">Update Status</label>

                                    <select name="status"  class="form-control" >
                                      <option value="pending">Pending</option>
                                      <option value="approved">Approved</option>
                                      <option value="not_approved">Not Approved</option>
                                      
                                    </select>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" >Submit</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>


                              <div class="modal fade" id="exampleModal2{{$single_item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <a href="{{url('/admin/request/delete/bid/'.$single_item->id)}}" class="btn btn-danger">Delete</a>
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
