@extends('admin.layout.apps')
@section('content')
<section id="container" >

<section id="main-content">
    <section class="wrapper">
    <!-- page start-->
    <a href="{{url('/admin/category/add')}}" class="btn btn-success">Add New +</a>
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
                            <th >Status</th>
                            <th >Action</th>
                        </tr>
                      </thead>
                        <tbody>
                          @foreach($all_cat  as $category)
                            <tr>
                              <td>{{$category->cat_name}}</td>
                              <td >@if($category->status=='active')
                              <span class="label label-primary" style="background-color: #28a745;"><a href="{{url('/status/'.$category->status.'/'.$category->cat_key)}}">Active</a></span>
                              @else
                              <span class="label label-danger" style="background-color: #ff1a30;"><a href="{{url('/status/'.$category->status.'/'.$category->cat_key)}}">In Active</a></span>
                              @endif
                              <td> <a href="{{url('/admin/category/edit/'.$category->cat_key)}}"><i class="fas fa-edit" data-toggle="tooltip" title="Edit"></i></a> 
                              <a href="" class="fas fa-trash-alt" title="Delete" data-toggle="modal" data-target="#exampleModal{{$category->cat_key}}">  </a></td>
                            
                            </tr>

                                <div class="modal fade" id="exampleModal{{$category->cat_key}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <a href="{{url('/admin/delete/category/'.$category->cat_key)}}" class="btn btn-danger">Delete</a>
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
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
</script>
@endsection
