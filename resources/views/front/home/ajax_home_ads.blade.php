@if($data!=null && $data!='')
  @if(count($data->data)>0)
    @if(@$data->data[0]->item_type=='service')
      @foreach($data->data as $row)
        <li class="services_list_li">
          <div class="services_list_box">
            <div class="services_list_slider">
              <div>
                <div class="services_list_run">
                  <h2>{{ucfirst($row->item_name)}} 
                    @php $star_class_active = '';@endphp
                    @if($row->is_liked==1)
                      @php $star_class_active = 'active';@endphp
                    @endif
                    <a class="bookmark_item_star item_star_dark {{$star_class_active}}" href="javascript:void(0)" onclick="add_favorite(this, '{{$row->id}}')"></a>
                  </h2>
                  <p>{!! nl2br($row->item_description) !!} </p>
                </div>
              </div>
              
              @foreach($row->photos as $single_file)
                <div>
                  <div class="deal_list_box">
                    <div class="deal_list_img"> 
                      <a href="{{url('/ad-detail?key=').$row->item_sef}}">
                        <img src="{{@$single_file->full_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">
                      </a> 
                      <a class="bookmark_item_star" href="javascript:void(0)"></a> 
                    </div>
                  </div>
                </div>
              @endforeach
              
            </div>
          </div>
        </li>
      @endforeach
    @else
      @foreach($data->data as $row)
        <li class="deal_li">
          <div class="deal_list_box">
            <div class="deal_list_img"> 
              <a href="{{url('/ad-detail?key=').$row->item_sef}}">
                <img src="{{@$row->photos[0]->full_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';">
              </a> 
              @php $star_class_active = '';@endphp
              @if($row->is_liked==1)
                @php $star_class_active = 'active';@endphp
              @endif
              <a class="bookmark_item_star {{$star_class_active}}" href="javascript:void(0)" onclick="add_favorite(this, '{{$row->id}}')"></a> 
            </div>
            <div class="deal_list_detail">
              <h3>
                <a href="{{url('/ad-detail?key=').$row->item_sef}}">{{ucfirst($row->item_name)}}</a>
              </h3>
              @if($row->item_type=='item')
                <div class="deal_list_auther"> 
                  <span>{{ucfirst(@$row->user->user_name) ?? 'N/A'}}</span> 
                </div>
              @elseif($row->item_type=='request')
                <div class="deal_list_auther deal_requestedRangetext">
                  <span>{{Lang::get('label.Requested Range')}}</span> 
                </div>
              @endif
              <div class="deal_list_price"> 
                @if($row->item_type=='item')
                  <strong>{{$row->user->language->currency_symbol  ?? '$'}}{{$row->item_to_price}}</strong>
                @elseif($row->item_type=='request')
                  <strong>{{$row->user->language->currency_symbol ?? '$'}}{{$row->item_from_price}} ~  {{$row->user->language->currency_symbol ?? '$'}}{{$row->item_to_price}}</strong>
                @endif
                <div class="deal_list_time">{{$row->promotion_end_date_format}}</div>
              </div>
            </div>
          </div>
        </li>
      @endforeach
    @endif
  @endif
  @if($data->total==0)
    <li class="deal_li no_record_div">
      <p>{{Lang::get('message.No ads are found matching your selection')}}</p>
    </li>
  @endif
@else
<li class="deal_li no_record_div">
<p>{{Lang::get('message.No ads are found matching your selection')}}</p>
</li>
@endif