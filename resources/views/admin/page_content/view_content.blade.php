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
                            <th >Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($all_content  as $single_content)
                            <tr>
                              <td>{{$single_content->page_name}}</td>
                              <td> <a href="{{url('/admin/content/edit/'.$single_content->page_key)}}"><i class="fas fa-edit"></i></a> 
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
