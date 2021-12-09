@if($data!=null && $data!='')
    @foreach($data as $row)
      <li>
        @php $active_class = '';@endphp
         @if($row->lang_key == @session()->get('lang_key'))
            @php $active_class = 'active';@endphp
         @endif
          <div class="pick_service_box {{$active_class}} {{Session::get('lang_key')}} {{$row->lang_key}}">
              <div class="pick_service_cell">
                  <input class="lang_check lang_check_ar" type="radio" name="lang_key" value="{{$row->lang_key}}">
                  @php $style = $row->thumb_image;@endphp
                  <i><img src="{{$style}}" alt="#"  onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}';"></i> 
                  <strong>{{ucfirst($row->lang_name)}}</strong> 
              </div>
          </div>
      </li>
    @endforeach
@else
  <li>
    <div class="pick_service_box active">
        <input class="lang_check lang_check_eng" checked="checked" type="radio"  name="lang_key" value="en">
        <div class="pick_service_cell"> 
            <i class="lang_check_eng_icon"></i> 
            <strong>English</strong> 
        </div>
    </div>
  </li>
@endif