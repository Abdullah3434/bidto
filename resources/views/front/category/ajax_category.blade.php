@if($data!=null && $data!='')
  @if(count($data)>0)
      @foreach($data as $row)
          <li class="deal_li">
            <div class="deal_list_box">
              <div class="deal_list_img"> 
                <a href="javascript:void(0)">
                  <img src="{{$row->thumb_image}}" alt="#">
                </a> 
              </div>
              <div class="deal_list_detail">
                <h3>
                  <a href="javascript:void(0)">{!!ucfirst($row->cat_name)!!}</a>
                </h3>
                <div class="deal_list_auther"> 
                  <span>{{$row->item_count}} Listing</span> 
                </div>
              </div>
            </div>
          </li>
      @endforeach
  @else
    <li class="deal_li no_record_div">
      <p>{{Lang::get('message.No ads are found matching your selection')}}</p>
    </li>
  @endif
@else
<li class="deal_li no_record_div">
  <p>{{Lang::get('message.No ads are found matching your selection')}}</p>
</li>
@endif