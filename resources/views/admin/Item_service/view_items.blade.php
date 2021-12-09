@extends('admin.layout.apps')
@section('content')
<section id="container" >

  <section id="main-content">
    <section class="wrapper">
    <!-- page start-->
    <h2><b>  View Services </b>  </h2>
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
                            <th>Title</th>
                            <th>Uer Name</th>
                            <th>Date Added</th>
                            <th>Prmotional</th>
                            <th>Status</th>
                            <th >Action</th>
                        </tr>
                      </thead> 
                        <tbody> 
                          @foreach($all_items as $single_item)
                            @php 
                              $user= $single_item->user_id;
                              $user_name = \App\Models\User::find($user);
                            @endphp  
                            <tr>
                              <td>{{$single_item->item_name}}</td>
                            
                              @if(($user_name))
                              <td>{{$user_name->user_name}}</td>
                              @else
                            <td>   </td> 
                            @endif
                            <td>{{date_format (new DateTime($single_item->promotion_end_date), 'd-m-Y')}}</td>
                             
                              
                              <td>@if($single_item->is_promotion=='1')
                                Yes 
                                @else
                                No
                                @endif

                              </td>


                              <td >@if($single_item->status=='active')
                              <span class="label label-primary" style="background-color: #28a745;"><a href="{{url('/admin/service/status/'.$single_item->status.'/'.$single_item->id)}}">Active</a></span>
                              @else
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href="{{url('/admin/service/status/'.$single_item->status.'/'.$single_item->id)}}">In Active</a></span>
                              @endif
                             

                              <td> <a href="{{url('/admin/service/edit/'.$single_item->id)}}"><i class="fas fa-edit" title="Edit"></i></a> 
                                 <a href="{{url('/admin/service/images/'.$single_item->id)}}"><i class="fas fa-image" title="Images"></i></a> 
                                 <!-- <a href="{{url('/admin/service/bids/'.$single_item->id)}}"><i class="fas fa-laptop" title="Bids"></i></a>  -->
                               
                                 <a href="" class="fas fa-trash-alt" data-toggle="modal" data-target="#exampleModal{{$single_item->id}}" title="Delete"></a>
                               
                              </td>
                            </tr>



                              <div class="modal fade" id="exampleModal{{$single_item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                      <a href="{{url('/admin/delete/service/'.$single_item->id)}}" class="btn btn-danger">Delete</a>
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
