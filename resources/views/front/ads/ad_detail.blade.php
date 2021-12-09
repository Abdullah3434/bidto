@extends('front.layout.app')

@section('content')
    <div class="all_content_box">
      <div class="content_main">
        <div class="active_deals_main">
          <div class="autoContent">
            <div class="product_content">
              <h2 class="product_title_back">
                <a class="product_back_arrow" href="{{url('/ad')}}"></a> 
                {{Lang::get('label.Active Deals')}}
              </h2>
              <div class="product_info_top">
                <div class="product_info_right">
                  <div class="product_slider_main">
                    <div class="product_slider_big">
                      @if(count($data->photos)>0)
                        @foreach($data->photos as $single_photo)
                          <div class="product_slider_run"> 
                            <span>
                              <img class="xzoom" xoriginal="{{$single_photo->full_image}}" src="{{$single_photo->full_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}'">
                            </span> 
                          </div>
                        @endforeach
                      @endif
                    </div>
                    <div class="product_thumb_slider">
                    @if(count($data->photos)>0)
                        @foreach($data->photos as $single_photo)
                          <div class="">
                            <div class="product_thumb_box"> 
                              <span>
                                <img src="{{$single_photo->full_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}'">
                              </span> 
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <div class="product_info_left">
                  @if($data->user_id == session()->get('loginned_user')->id)
                    <h1 class="product_approvedBid_title">{!! ucfirst($data->item_name) !!}
                      <a class="product_approvedBid_title_edit" href="javascript:void(0)"></a>
                    </h1>
                  @else
                    <h1>{!! ucfirst($data->item_name) !!}</h1>
                  @endif
                  <h2>{{ucfirst(@$data->make->make_name)}}</h2>
                  <div class="product_timeLeft">
                    <div class="product_timeLeft_text"> 
                      <strong>{{Lang::get('label.Time Left')}}</strong> 
                      <span>{{$data->promotion_end_date_format}}</span> 
                    </div>
                    <div class="product_timeLeft_more">
                      <ul>
                        <!--<li>
                          <a class="product_setReminder_link" href="javascript:void(0)">{{Lang::get('label.Set Reminder')}}</a>
                        </li>-->
                        @if($data->user_id == session()->get('loginned_user')->id)
                          <li>
                            <a class="product_extend_link" href="javascript:void(0)">{{Lang::get('label.Extend')}}</a>
                          </li>
                        @endif
                        <li>
                          <a class="product_share_link" href="javascript:void(0)">{{Lang::get('label.Share')}}</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="product_owner_info">
                    <ul>
                      <li>
                        <div class="product_owner_text product_userInfo_owner"> 
                          <small>{{Lang::get('label.Owner')}}</small>
                          <h3>
                            <a class="product_user_name verified" href="{{url('profile?')}}">{{ucfirst(@$data->user->user_name)}}</a>
                          </h3>
                        </div>
                      </li>
                      @if($data->item_location!='' || $data->item_location!=null)
                        <li>
                          <div class="product_owner_text product_userInfo_location"> 

                                        
                            <small>{{Lang::get('label.Location')}}</small>
                            <a target="_blank" href="http://maps.google.com/maps?q={{nl2br(str_replace(" ", "+", str_replace(',',"",$data->item_location)))}}">
                                <h3>{{$data->item_location}}</h3>
                            </a>
                          </div>
                        </li>
                      @endif
                      @if($data->item_type=='item' || $data->item_type=='request')
                      <li>
                        <div class="product_owner_text product_userInfo_buyPrice"> 
                          <small>{{Lang::get('label.Buying Price')}}</small>
                          @if($data->item_type=='item')
                            <h3>{{$data->item_to_price}} {{@$data->user->language->currency_code}}</h3>
                          @elseif($data->item_type=='request')
                            <h3>{{$data->item_from_price}}~{{$data->item_to_price}} {{@$data->user->language->currency_code}}</h3>
                          @endif
                        </div>
                      </li>
                      @endif
                      <li>
                        <div class="product_owner_text product_userInfo_views"> 
                          <small>{{Lang::get('label.Views')}}</small>
                          <h3>{{$data->views_format}}</h3>
                        </div>
                      </li>
                    </ul>
                  </div>
                 <!-- <div class="product_price_row">
                    <div class="product_price_left">
                          @if($data->is_promotion==1)
                              <h3>{{$data->item_promotion_price}}</h3>
                              <small>{{@$data->user->language->currency_code}}</small> 
                          @endif
                      
                    </div>
                    <div class="product_price_right"> 
                      <a class="all_buttons all_small light_green has_tick_icon pro_directPurchase_btn" href="javascript:voi(0)">{{Lang::get('label.Direct Purchase')}}</a> 
                    </div>
                  </div>-->
                </div>
              </div>
              <div class="product_specs_main">
                <div class="product_specs_right">
                  @if($data->item_type=='item')
                    <div class="product_specs_listOuter">
                      <div class="product_specs_title">
                        <h3>{{Lang::get('label.Technical Specs')}}</h3>
                      </div>
                      <div class="product_specs_list">
                        <ul>
                          <li>
                            <p>
                              <span>{{Lang::get('label.Make')}}</span>
                              <strong>{{ucfirst(@$data->make->make_name)}}</strong>
                            </p>
                          </li>
                          <li>
                            <p>
                              <span>{{Lang::get('label.Transmission')}}</span>
                              <strong>{{ucfirst(@$data->transmission->transmission_name)}}</strong>
                            </p>
                          </li>
                          <li>
                            <p>
                              <span>{{Lang::get('label.Model')}}</span>
                              <strong>{{ucfirst(@$data->model->model_name)}}</strong>
                            </p>
                          </li>
                          <li>
                            <p>
                              <span>{{Lang::get('label.Interior Color')}}</span>
                              <strong>{{ucfirst(@$data->interior_color->color_name)}}</strong>
                            </p>
                          </li>
                          <li>
                            <p>
                              <span>{{Lang::get('label.Exterior Color')}}</span>
                              <strong>{{ucfirst(@$data->exterior_color->color_name)}}</strong>
                            </p>
                          </li>
                          <li>
                            <p><span>{{Lang::get('label.Number of Cylinders')}}</span>
                            <strong>{{ucfirst(@$data->cylinder->item_cylinder)}} {{Lang::get('label.Cylinders')}}</strong>
                          </p>
                          </li>
                          <li>
                            <p><span>{{Lang::get('label.Year')}}</span>
                            <strong>{{$data->item_year}}</strong>
                          </p>
                          </li>
                          
                          <li>
                            <p><span>{{Lang::get('label.New or Used')}}</span>
                            <strong>{{@$data->condition->condition_name}}</strong>
                          </p>
                          </li>
                          <li>
                            <p><span>{{Lang::get('label.Max Price')}}</span>
                            <strong>{{$data->item_to_price}} {{@$data->user->language->currency_code}}</strong>
                          </p>
                          </li>
                        </ul>
                      </div>
                    </div>
                  @endif
                </div>
                @if($data->user_id == session()->get('loginned_user')->id)
                    <div class="product_specs_left">
                      <div class="product_specs_title">
                        <div class="filter_serviceItems_menu profile_info_menu full_width">
                          <ul class="mr0">
                            <li><a class="productApproved_pendingBid_link " href="javascript:void(0)" onclick="load_pending_bids()">Pending Bids</a></li>
                            <li><a class="productApproved_approveBid_link active" href="javascript:void(0)" onclick="load_approved_bids()">Approved Bids</a></li>
                          </ul>
                        </div>
                      </div>
                      <div class="product_bid_table_main">
                        <div class="all_table_main">
                          <div class="table_content">
                             <ul id="productApproved_pendingBid_link">
                               
                             </ul>


                              <ul id="productApproved_approveBid_link" style="display:none;">
                                
                              </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                @else
                    <div class="product_specs_left">
                      <div class="product_specs_title">
                        <h3>{{Lang::get('label.Current Bids')}}</h3>
                        <a class="product_specs_newBid_link" href="javascript:void(0)">{{Lang::get('label.New Bid')}}</a> 
                      </div>
                      <div class="product_bid_table_main">
                        <div class="all_table_main">
                          <div class="table_content">
                            <ul>
                          
                              @if($data->bids!=null)
                                  <li class="all_table_li">
                                    <div class="table_row">
                                      <div class="table_cell bid_cell1">
                                        <div class="bid_table_userInfo">
                                          <div class="bid_userAvatar">
                                            <img src="{{asset('public/front_assets/images/bid_user_avatar.png')}}" alt="#">
                                          </div>
                                          <strong>Khalid Saied</strong> 
                                        </div>
                                      </div>
                                      <div class="table_cell bid_cell2">
                                        <p>50,000 KD</p>
                                      </div>
                                      <div class="table_cell bid_cell3"> 
                                        <a class="bidCell_icon bid_cell_edit_icon" href="javascript:void(0)"></a> 
                                      </div>
                                      <div class="table_cell bid_cell4"> 
                                        <a href="javascript:void(0)" class="bidCell_icon hash_tag tag_green">#1</a> 
                                      </div>
                                    </div>
                                  </li>
                              @else
                                    <li class="deal_li no_record_div">
                                      <p>{{Lang::get('message.No bids are found matching your selection')}}</p>
                                    </li>
                              @endif
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="all_popup small_popup createNew_bid_popup">
      <div class="popup_table_wrap">
        <div class="popup_cell_wrap">
          <div class="popup_auto">
            <div class="popup_detail">
              <div class="popup_content">
                  <a class="popup_mob_close" href="javascript:void(0)"></a> 
                  <strong class="popup_title_heading">{{Lang::get('label.Add New Bid')}}</strong>
                  <div class="uploadImages_row">
                    <div class="item_info_form has_dark_placeholder">
                      <div class="formParent">
                        <div class="formRow clearfix">
                          <div class="formCell col12">
                            <div class="form_field bid_priceField">
                              <input type="text" name="bid_amount" id="bid_amount" placeholder="" onclick="bid_field_mask(this)">
                              <i>{{session()->get('currency')}}</i> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="pick_item_proceed_out"> <a class="add_bid_save_btn all_buttons btn_block light_green" href="javascript:void(0)" onclick= "add_new_bid(this)">Add New Bid</a> </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="popup_overlay"></div>
        </div>
      </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
      $(document).ready(function(e) { 
         // setTimeout(function(){ 
            $('.product_slider_big').slick({
              slidesToShow: 1,
              slidesToScroll: 1,
              arrows: false,
              fade: true,
              asNavFor: '.product_thumb_slider',
              infinite: true,
              adaptiveHeight: true
            }); 
            $('.product_thumb_slider').slick({
              slidesToShow: 3,
              slidesToScroll: 1,
              asNavFor: '.product_slider_big',
              dots: false,
              centerMode: false,
              focusOnSelect: true,
              infinite: true,
              arrows: true,
           });
            $(".slick-active .xzoom").xzoom({
                position: 'left',
                lensShape: 'circle',
                defaultScale: -1,
            });
            zoomTouchMove();
            $('.product_slider_big').on('afterChange', function(event, slick, currentSlide, nextSlide){
                setTimeout(function(){
                      $(".slick-active .xzoom").xzoom({
                        position: 'left',
                        lensShape: 'circle',
                        defaultScale: -1,
                      });
                      zoomTouchMove();
                      $(".xzoom-source").remove();
                },200);
              // $(".xzoom-source").remove();
            });
         // }, 3000);
      
      });
      function bid_field_mask(obj){
	      $(obj).mask('00000000000');
      }
      function zoomTouchMove(){
          //Integration with hammer.js
          var isTouchSupported = 'ontouchstart' in window;

          if (isTouchSupported) {
              //If touch device
              $('.slick-active .xzoom').each(function(){
                  var xzoom = $(this).data('xzoom');
                // xzoom.eventunbind();
              });
              
              $('.slick-active .xzoom').each(function() {
                  var xzoom = $(this).data('xzoom');
                  $(this).hammer().on("tap", function(event) {
                      event.pageX = event.gesture.center.pageX;
                      event.pageY = event.gesture.center.pageY;
                      var s = 1, ls;
      
                      xzoom.eventmove = function(element) {
                          element.hammer().on('drag', function(event) {
                              event.pageX = event.gesture.center.pageX;
                              event.pageY = event.gesture.center.pageY;
                              xzoom.movezoom(event);
                              event.gesture.preventDefault();
                          });
                      }
      
                      xzoom.eventleave = function(element) {
                          element.hammer().on('tap', function(event) {
                              xzoom.closezoom();
                          });
                      }
                      xzoom.openzoom(event);
                  });
              });
          } 
      }

      $(document).ready(function(e){
            if("{{$data->user_id}}" == "{{session()->get('loginned_user')->id}}"){
              $('.product_bid_table_main').addClass('is_loading');
              load_approved_bids();
              load_pending_bids();
              $('.product_bid_table_main').removeClass('is_loading');
            }


            $('.productApproved_pendingBid_link').click(function(e){

                $('.productApproved_approveBid_link').removeClass('active');
                $('#productApproved_approveBid_link').hide();

                $('.productApproved_pendingBid_link').addClass('active');
                $('#productApproved_pendingBid_link').show();
            });

            $('.productApproved_approveBid_link').click(function(e){
            
                $('.productApproved_pendingBid_link').removeClass('active');
                $('#productApproved_pendingBid_link').hide();

                $('.productApproved_approveBid_link').addClass('active');
                $('#productApproved_approveBid_link').show();
            })
      });

      function load_pending_bids(){
      
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/pending-bids') }}",
            type: 'POST',
            data: {'item_id': '{{$data->id}}'},
        }).done(function (result) {
            $('#productApproved_pendingBid_link').html(result.data);
            
        });
      }

      function load_approved_bids(){
        
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/approved-bids') }}",
            type: 'POST',
            data: {'item_id': '{{$data->id}}'},
        }).done(function (result) {
            $('#productApproved_approveBid_link').html(result.data);
           
        });
      }

      function add_new_bid(d){
        var amount = $('.createNew_bid_popup').find('#bid_amount').val();
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/add-bid') }}",
            type: 'POST',
            data: {'item_id': '{{$data->id}}', 'amount':amount},
        }).done(function (result) {
           window.location.reload(true);
           
        });
      }

    </script>
@stop