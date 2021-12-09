@extends('admin.layout.apps')
@section('content')
<section id="container" >

<section id="main-content">
    <section class="wrapper">
   
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
                            <th>Email</th>
                            <th>Phone</th>
                            <th >Status</th>
                            <th >Is Varified</th>
                            <th >Action</th>
                        </tr>
                      </thead>
                        <tbody>
                          @foreach($all_users  as $single_user)
                            <tr>
                              <td>{{$single_user->user_name}}</td>
                              <td>{{$single_user->user_email}}</td>
                              <td>{{$single_user->user_phone}}</td>
                             
                              <td >@if($single_user->status=='active')
                              <span class="label label-primary" style="background-color: #28a745;"><a href="{{url('/admin/users/status/'.$single_user->status.'/'.$single_user->id)}}">Active</a></span>
                              @else  
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href="{{url('/admin/users/status/'.$single_user->status.'/'.$single_user->id)}}">In Active</a></span>
                              @endif
                              <td >@if($single_user->is_verified=='0')
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href="{{url('/admin/users/verify/'.$single_user->is_verified.'/'.$single_user->id)}}">Not Verified</a></span>
                              @else
                              <span class="label label-primary" style="background-color: #28a745;"><a href="{{url('/admin/users/verify/'.$single_user->is_verified.'/'.$single_user->id)}}">Verified</a></span>
                              @endif 
                              
                              <td> 
                                <a href="{{url('admin/user/edit/'.$single_user->id)}}"><i class="fas fa-edit" title="edit"></i></a> 
                               <a href="{{url('/admin/user/transactions/'.$single_user->id)}}"><i class="fas fa-dollar-sign" title="Transactions"></i></a> 
                               <a href="{{url('/admin/user/reviews/'.$single_user->id)}}"><i class="fa fa-comments" aria-hidden="true" title="Reviews"></i></a> 
                               <a href="{{url('/admin/user/cards/'.$single_user->id)}}"><i class="fas fa-credit-card" title="Credit Card"></i></a>
                               <a href="{{url('/admin/user/chat-thread/'.$single_user->id)}}"><i class="fas fa-comment-alt" title="Thread"></i></a>
                               <a href="" class="fas fa-trash-alt" title="Delete" data-toggle="modal" data-target="#exampleModal{{$single_user->id}}">  </a>
                             
                              </td>
                             
                            </tr>

                                <div class="modal fade" id="exampleModal{{$single_user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <a href="{{url('/admin/delete/user/'.$single_user->id)}}" class="btn btn-danger">Delete</a>
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
