@if($data!=null && $data!='')
  @if(count($data->data)>0)
        @foreach($data as $row)
            <li class="all_table_li">
              <div class="table_row">
                <div class="table_cell bid_cell1">
                  <div class="bid_table_userInfo">
                    <div class="bid_userAvatar">
                      <img src="images/bid_user_avatar.png" alt="#">
                    </div>
                    <strong>Khalid Saied</strong> </div>
                </div>
                <div class="table_cell bid_cell2">
                  <p>50,000 KD</p>
                </div>
                <div class="table_cell bid_cell3"> 
                  <a class="bid_approved_tbl_icon bid_approved_doubleTick" href="javascript:void(0)"></a> 
                </div>
                <div class="table_cell bid_cell4"> 
                  <a href="javascript:void(0)" class="bid_approved_tbl_icon bid_approved_delete">#1</a> 
                </div>
              </div>
            </li>
        @endforeach
  @endif
  @if($data->total==0)
    <li class="deal_li no_record_div">
      <p>{{Lang::get('message.No bids are found matching your selection')}}</p>
    </li>
  @endif
@else
<li class="deal_li no_record_div">
<p>{{Lang::get('message.No bids are found matching your selection')}}</p>
</li>
@endif


