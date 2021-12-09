<option data-value="" >{{Lang::get("label.Category")}}</option>
@if($data!=null && $data!='')
    @foreach($data as $row)
      <option data-value="{{$row->cat_key}}" >{!! ucfirst($row->cat_name) !!}</option>
    @endforeach
@endif


