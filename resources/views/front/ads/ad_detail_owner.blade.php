@extends('front.layout.app')

@section('content')
<div class="all_content_box">
      <div class="content_main">
        <div class="active_deals_main">
          <div class="autoContent">
            <div class="product_content">
              <h2 class="product_title_back">
                <a class="product_back_arrow" href="javascript:void(0)"></a> {{Lang::get('label.Active Deals')}}</h2>
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
                  
                  <h2>{{ucfirst(@$data->make->make_name)}}</h2>
                  <div class="product_timeLeft">
                    <div class="product_timeLeft_text"> 
                      <strong>{{Lang::get('label.Time Left')}}</strong> 
                      <span>{{$data->promotion_end_date_format}}</span> 
                    </div>
                    <div class="product_timeLeft_more">
                      <ul>
                        <li>
                          <a class="product_extend_link" href="javascript:void(0)">{{Lang::get('label.Extend')}}</a>
                        </li>
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

                          <a target="_blank" href="http://maps.google.com/maps?q={{nl2br(str_replace(" ", "+", str_replace(',',"",$data->item_location)))}}">
                                        
                            <small>{{Lang::get('label.Location')}}</small>

                            <h3>{{$data->item_location}}</h3>
                          </div>
                        </li>
                      @endif
                      <li>
                        <div class="product_owner_text product_userInfo_buyPrice"> <small>Buying Price</small>
                          <h3>31,000 KD</h3>
                        </div>
                      </li>
                      <li>
                        <div class="product_owner_text product_userInfo_views"> <small>Views</small>
                          <h3>10,920</h3>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="product_price_row">
                    <div class="product_price_left">
                      <h3>3,928,00</h3>
                      <small>KD</small> </div>
                  </div>
                </div>
              </div>
              <div class="product_specs_main">
                <div class="product_specs_right">
                  <div class="product_specs_listOuter">
                    <div class="product_specs_title">
                      <h3>Technical Specs</h3>
                    </div>
                    <div class="product_specs_list">
                      <ul>
                        <li>
                          <p><span>Make</span><strong>Toyota</strong></p>
                        </li>
                        <li>
                          <p><span>Transmission</span><strong>Automatic</strong></p>
                        </li>
                        <li>
                          <p><span>Model</span><strong>Camry</strong></p>
                        </li>
                        <li>
                          <p><span>Interior Color</span><strong>Red</strong></p>
                        </li>
                        <li>
                          <p><span>Exterior Color</span><strong>Black</strong></p>
                        </li>
                        <li>
                          <p><span>Number of Cylinders</span><strong>8 Cylinders</strong></p>
                        </li>
                        <li>
                          <p><span>Oldest Year</span><strong>2017</strong></p>
                        </li>
                        <li>
                          <p><span>Newest Year</span><strong>2021</strong></p>
                        </li>
                        <li>
                          <p><span>New or Used</span><strong>New</strong></p>
                        </li>
                        <li>
                          <p><span>Max Price</span><strong>40,000 KD</strong></p>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="product_specs_left">
                  <div class="product_specs_title">
                    <div class="filter_serviceItems_menu profile_info_menu full_width">
                      <ul class="mr0">
                        <li><a class="productApproved_pendingBid_link " href="javascript:void(0)">Pending Bids</a></li>
                        <li><a class="productApproved_approveBid_link active" href="javascript:void(0)">Approved Bids</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="product_bid_table_main">
                    <div class="all_table_main">
                      <div class="table_content">
                        <ul id="productApproved_approveBid_link">
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                        </ul>


                        <ul id="productApproved_approveBid_link">
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar"><img src="images/bid_user_avatar.png" alt="#"></div>
                                  <strong>Khalid Saied</strong> </div>
                              </div>
                              <div class="table_cell bid_cell2">
                                <p>50,000 KD</p>
                              </div>
                              <div class="table_cell bid_cell3"> <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> </div>
                              <div class="table_cell bid_cell4"> <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> </div>
                            </div>
                          </li>
                        </ul>

                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
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

     
    </script>
@stop