<li><a class="filter_cat_btn active" href="javascript:void(0)" data-value="all" onclick="change_category(this)">{!! Lang::get('label.All') !!}</a></li>
@if($data!=null && $data!='')
    @foreach($data as $row)
        <li>
          <a class="filter_cat_btn" href="javascript:void(0)" data-value="{{$row->cat_key}}" onclick="change_category(this)">{!! ucfirst($row->cat_name) !!}</a>
        </li>
    @endforeach
@endif