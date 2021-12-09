@extends('admin.layout.apps')
@section('content')


<section id="main-content">
  
  <section class="wrapper">
    <!-- page start-->
    <a href="{{url('/admin/color/add')}}" id="editable-sample_new" class="btn btn-success">Add New <i class="fa fa-plus"></i></a>
   
      <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                
                <div class="panel-body">
                    @if (Session::has('success'))
                      <div class="alert alert-success">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                              {{Session::get('success') }}
                          
                      </div>
                    @endif
                    
                   
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                  
                      <thead>
                          <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th >Action</th>
                          </tr>
                      </thead>
                    <tbody>
                      @foreach($all_color  as $single_color)
                        <tr>
                          <td>{{$single_color->id}}</td>
                          <td>{{$single_color->color_name}}</td>
                          <td> <a href="{{url('/admin/color/edit/'.$single_color->id)}}"><i class="fas fa-edit"></i></a> 
                          <a href="" class="fas fa-trash-alt" data-toggle="modal" data-target="#exampleModal{{$single_color->id}}"></a></td>
                        </tr>



                          <div class="modal fade" id="exampleModal{{$single_color->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                  <a href="{{url('/admin/delete/color/'.$single_color->id)}}" class="btn btn-danger">Delete</a>
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

@endsection
 