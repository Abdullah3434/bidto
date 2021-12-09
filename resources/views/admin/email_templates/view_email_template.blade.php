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
                  
                  <!-- <input id="myInput" type="text" placeholder="Search.."> -->
                    <table  id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                          <tr>
                            <th>Name</th>
                            <th >Action</th>
                          </tr>
                      </thead>
                        <tbody id="myTable">
                          @foreach($all_temp  as $single_template)
                            <tr>
                              <td>{{$single_template->email_name}}</td>
                              <td> <a href="{{url('/admin/email-temp/edit/'.$single_template->id)}}"><i class="fas fa-edit"></i></a> 
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
