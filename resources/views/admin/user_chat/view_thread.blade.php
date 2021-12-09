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
                            <th>Post Title</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Last Message Date </th>
                            <th >Action</th>
                        </tr>
                      </thead> 
                        <tbody> 
                          @foreach($ifexist as $single_model)
                            <tr>
                                @php 
                                    $from= $single_model->from_id;
                                    $to= $single_model->to_id;
                                    $item_id= $single_model->item_id;
                                    $from_name = \App\Models\User::find($from);
                                    $to_name = \App\Models\User::find($to);
                                    $item_name = \App\Models\Item::find($item_id);
                                
                                @endphp
                                  <td>{{$item_name->item_name}}</td>
                                  <td>{{$from_name->user_name}}</td>
                                  <td>{{$to_name->user_name}}</td>  
                                  <td>{{date_format($last_msg,"d-m-Y H:i:s")}}</td>
                                   
                                  <td> <a href="{{url('/admin/users/chat/'.$single_model->id.'/'.$single_model->from_id.'/'.$single_model->to_id)}}"><i class="fas fa-comment" title="Chat"></i></a> 
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
