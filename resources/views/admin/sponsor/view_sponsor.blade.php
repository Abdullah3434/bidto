@extends('admin.layout.apps')
@section('content')
<section id="container" >

<section id="main-content">
    <section class="wrapper">
    <!-- page start-->
    <a href="{{url('/admin/sponsor/add')}}" class="btn btn-success">Add New +</a>
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
                          <th>URL</th>
                          <th >Action</th>
                        </tr>
                      </thead>
                <tbody>
                  @foreach($all_sponsors  as $single_sponsor)
                    <tr>
                      <td>{{$single_sponsor->sponsor_name}}</td>
                      <td>{{$single_sponsor->sponsor_url}}</td>
                      <td> <a href="{{url('/admin/sponsor/edit/'.$single_sponsor->id)}}"><i class="fas fa-edit"></i></a> 
                      <a href="" class="fas fa-trash-alt" data-toggle="modal" data-target="#exampleModal{{$single_sponsor->id}}"></a></td>
                    </tr>



                  <div class="modal fade" id="exampleModal{{$single_sponsor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                          <a href="{{url('/admin/delete/sponsor/'.$single_sponsor->id.'/'.$single_sponsor->sponsor_image)}}" class="btn btn-danger">Delete</a>
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
