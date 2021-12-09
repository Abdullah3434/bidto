@extends('front.layout.app')

@section('content')
    <div class="all_content_box">
      <div class="content_main">
        <div class="active_deals_main categories_main_content">
          <div class="autoContent">
            <div class="active_deals_content">
              <div class="deals_filter_row">
                <div class="filter_title">
                  <h2>Categories</h2>
                </div>
              </div>
              <div class="deal_listing_main">
                <ul id="ajax_category">
                 
                 
                 
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
   var page = 0;
   var limit = 1;
   var empty_rec= false;
  $(document).ready(function(e) {
    get_ajax_categories();
  });
  // calling when filter popup open to get categories
  function get_ajax_categories(){
        page = page+1;
        $('.deal_listing_main').addClass('is_loading');
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            url: "{{ url('/get-ajax-category') }}",
            type: 'GET',
            data: {'page_no' : page},
        }).done(function (result) {
      
           $('.deal_listing_main').removeClass('is_loading');

           if($('.deal_listing_main').find("#ajax_category").find('li.deal_li').hasClass('no_record_div')){
                empty_rec = true;
           }
            if(empty_rec==true){

            }else{
              $('.deal_listing_main').find('#ajax_category').append(result.data);
            }
           
        });
    }

    $(window).scroll(function() {
      if(($(window).scrollTop() == $(document).height() - $(window).height()) || ((window.innerHeight + Math.ceil(window.pageYOffset)) >= document.body.offsetHeight)) {
        get_ajax_categories();
      }
    });
</script>
@stop