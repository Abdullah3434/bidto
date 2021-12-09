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
                  <div class="adv-table">
                    <table  id="example" class="table table-striped table-bordered" style="width:100%">
                      <thead>
                        <tr>
                          
                          <th>Key</th>
                          <th >Value</th>
                          <th >Action</th>
                        </tr>
                      </thead>
                <tbody>
                  @foreach($all_settings  as $single_setting)
                    <tr>
                      <td>{{$single_setting->key}}</td>
                      <td>{{$single_setting->value}}</td>
                      <td> <a href="{{url('/admin/setting/edit/'.$single_setting->id)}}"><i class="fas fa-edit"></i></a> 
                    </tr>

                  @endforeach

                </tbody>
        
                </table>
                </div>
                </div>
            </section>
        </div>
    </div>
   
    </section>
</section>
</section>

@endsection
