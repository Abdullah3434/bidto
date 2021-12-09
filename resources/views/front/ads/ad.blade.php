@extends('front.layout.app')

@section('content')
<div class="all_content_box">
      <div class="content_main">
        <div class="active_deals_main">
          <div class="autoContent">
            <div class="active_deals_content">
              <div class="deals_filter_row">
                <div class="filter_title">
                  <h2>{{Lang::get('label.Active Deals')}}</h2>
                </div>
                <div class="filter_sellingBuy_box">
                  <ul>
                    <li><a class="filter_sellingBuy_btn filter_sellingBuy_itemSell" href="javascript:void(0)" data-value="1">{{Lang::get('label.Selling Items')}}</a></li>
                    <li><a class="filter_sellingBuy_btn filter_sellingBuy_itemBuy" href="javascript:void(0)" data-value="0">{{Lang::get('label.Buying Items')}}</a></li>
                  </ul>
                </div>
                <div class="filter_serviceItems_menu">
                  <ul>
                    <li><a class="filter_serviceItems_link item" href="javascript:void(0)" data-value="item">{{Lang::get('label.Items')}}</a></li>
                    <li><a class="filter_serviceItems_link service" href="javascript:void(0)" data-value="service">{{Lang::get('label.Services')}}</a></li>
                    <li><a class="filter_serviceItems_link request" href="javascript:void(0)" data-value="request">{{Lang::get('label.Requests')}}</a></li>
                  </ul>
                </div>
                <div class="filter_sort_btns_box">
                  <ul>
                    <li><a class="filter_sort_btn deal_sort_btn" href="javascript:void(0)"></a></li>
                    <li><a class="filter_sort_btn deal_filter_btn" href="javascript:void(0)" onclick="get_categories()"></a></li>
                    <li><a class="filter_addNewList_btn all_buttons has_plus_icon all_small all_green has_icon" href="javascript:void(0)">{{Lang::get('label.Add New Listing')}}</a></li>
                  </ul>
                </div>
              </div>
              <div class="deal_listing_main">
                <ul id="filter_ajax_ads">
                  
                </ul>
              </div>
              <div class="services_listing_main" style="display:none">
                <ul class="services_list_ul" id="filter_ajax_service_ad">
                  
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
       var is_selling = 0;
       var type = 'item';
       $(document).ready(function(e) {
          // switch between  selling item and buying item 
          $('.filter_sellingBuy_btn').click(function(e){
              $('.filter_sellingBuy_btn').removeClass('active');
              $(this).addClass('active');
              is_selling =$(this).attr('data-value');

              const queryString = window.location.search;
              let url = APP_URL + '/ad/' + queryString;
              let href = new URL(url);
              href.searchParams.set('selling', is_selling);
              location.href = href.toString();
          });

          // switch between item, request  and service
          $('.filter_serviceItems_link').click(function(e){
              $('.filter_serviceItems_link').removeClass('active');
              $(this).addClass('active');
              type = $(this).attr('data-value');
              const queryString = window.location.search;
              let url = APP_URL + '/ad/' + queryString;
              let href = new URL(url);
              href.searchParams.set('type', type);
              location.href = href.toString();
          })
       });

      
        $(window).scroll(function() {
            if(($(window).scrollTop() == $(document).height() - $(window).height()) || ((window.innerHeight + Math.ceil(window.pageYOffset)) >= document.body.offsetHeight)) {
              filter_ajax_ads(1, 'ad');
            }
        });
        
    </script>
@stop
