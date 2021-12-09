@extends('admin.layout.apps')
@section('content')
<section id="container" >

<section id="main-content">
    <section class="wrapper">
    <!-- page start-->
 
      <div class="row">
          <div class="col-sm-12">
              <section class="panel">
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
                            <th >Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($all_notifications  as $single_notification)
                            <tr>
                              <td>{{$single_notification->notification_name}}</td>
                              <td> <a href="{{url('/admin/notification/template/edit/'.$single_notification->id)}}"><i class="fas fa-edit"></i></a> 
                            </tr>
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
