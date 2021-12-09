@extends('layouts.auth')

@section('content')
<div class="all_content_box">
  <div class="content_main">
    <div class="active_deals_main">
      <div class="autoContent">
        <div class="sponsors_content">
          <div class="sponsors_title">
            <h2>{{Lang::get("label.Our Sponsors")}}</h2>
            <p>{{Lang::get("label.Check the list of our sponsors and let us know if you want to join them!")}}</p>
          </div>
          <div class="sponsors_list">
            <ul>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/hilton-international-2.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/sheraton-hotels-resorts-1.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/ascot-hotel.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/radisson-slavjanskaya-hotel.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/mayorazgo-hotel.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/marriott-hotels-resorts-suites.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/hilton-international-2.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/hilton-international-2.svg')}}" alt="#">
                </a>
              </li>
              <li>
                <a class="sponsors_logo" href="javascript:void(0)">
                  <img src="{{asset('public/front_assets/images/sponsors/sheraton-hotels-resorts-1.svg')}}" alt="#">
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
@endsection
<script type="text/javascript">
</script>
