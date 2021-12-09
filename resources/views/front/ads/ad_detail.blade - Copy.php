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
                              <img class="xzoom" xoriginal="{{$single_photo->full_image}}" src="{{$single_photo->thumb_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}'">
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
                                <img src="{{$single_photo->thumb_image}}" alt="#" onerror="this.onerror=null;this.src='{{asset('public/uploads/no_ad_image.png')}}'">
                              </span> 
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <div class="product_info_left">
                  <h1>{!! ucfirst($data->item_name) !!}</h1>
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

                            <h3>{{$data->item_location}}</h3>
                          </div>
                        </li>
                      @endif
                      @if($data->item_type=='item' || $data->item_type=='request')
                      <li>
                        <div class="product_owner_text product_userInfo_buyPrice"> 
                          <small>{{Lang::get('label.Buying Price')}}</small>
                          @if($data->item_type=='item')
                            <h3>{{$data->item_from_price}} {{@$data->user->language->currency_code}}</h3>
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
                  <div class="product_price_row">
                    <div class="product_price_left">
                          @if($data->is_promotion==1)
                              <h3>{{$data->item_promotion_price}}</h3>
                              <small>{{@$data->user->language->currency_code}}</small> 
                          @endif
                      
                    </div>
                    <div class="product_price_right"> 
                      <a class="all_buttons all_small light_green has_tick_icon pro_directPurchase_btn" href="javascript:voi(0)">{{Lang::get('label.Direct Purchase')}}</a> 
                    </div>
                  </div>
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
                            <p><span>{{Lang::get('label.Oldest Year')}}</span>
                            <strong>{{$data->item_year_old}}</strong>
                          </p>
                          </li>
                          <li>
                            <p><span>{{Lang::get('label.Newest Year')}}</span>
                            <strong>{{$data->item_year_new}}</strong>
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
                <div class="product_specs_left">
                  <div class="product_specs_title">
                    <h3>Current Bids</h3>
                    <a class="product_specs_newBid_link" href="javascript:void(0)">New Bid</a> 
                  </div>
                  <div class="product_bid_table_main">
                    <div class="all_table_main">
                      <div class="table_content">
                        <ul>
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
                          <li class="all_table_li">
                            <div class="table_row">
                              <div class="table_cell bid_cell1">
                                <div class="bid_table_userInfo">
                                  <div class="bid_userAvatar">
                                    <img src="{{asset('public/front_assets/images/bid_user_avatar.png')}}" alt="#">
                                  </div>
                                  <strong>Khalid Saied</strong> </div>
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
