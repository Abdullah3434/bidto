
    <div class="formCell col6">
      <div class="selectbox"> 
        <span class="selectbox_span">{{Lang::get("label.Item Type")}}</span>
          <select class="dropdown_type" id="dropdown_type"  name="ad_type" onchange="change_dropdown_item_type(this)">
            <option data-value="" >{{Lang::get("label.Item Type")}}</option>
            @if($data->item_types!=null && $data->item_types!='')
                @foreach($data->item_types as $single_type)
                  <option data-value="{{$single_type->type_key}}" >{!! ucfirst($single_type->type_name) !!}</option>
                @endforeach
            @endif
          </select>
      </div>
    </div>
    <div class="formCell col6">
      <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.New or Used")}}</span>
          <select class="dropdown_condition" id="dropdown_condition"  name="ad_condition" onchange="change_dropdown_item_condition(this)">
            <option data-value="" >{{Lang::get("label.New or Used")}}</option>
            @if($data->item_conditions!=null && $data->item_conditions!='')
                @foreach($data->item_conditions as $single_condition)
                  <option data-value="{{$single_condition->id}}" >{!! ucfirst($single_condition->condition_name) !!}</option>
                @endforeach
            @endif
          </select>
      </div>
    </div>
    <div class="formCell col6">
      <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.Make")}}</span>
          <select class="dropdown_make" id="dropdown_make"  name="ad_make" onchange="change_dropdown_item_make(this)">
            <option data-value="" >{{Lang::get("label.Make")}}</option>
            @if($data->item_makes!=null && $data->item_makes!='')
                @foreach($data->item_makes as $make_key => $single_make)
                  <option data-value="{{$single_make->id}}"  data-key="{{$make_key}}">{!! ucfirst($single_make->make_name) !!}</option>
                @endforeach
            @endif
          </select>
      </div>
    </div>
    <div class="formCell col6">
      <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.Model")}}</span>
          <select class="dropdown_model" id="dropdown_model"  name="ad_model" onchange="change_dropdown_item_model(this)">
           
          </select>
      </div>
    </div>
    <div class="formCell col6">
      <div class="form_field">
        <input class="ad_max_price" id="ad_max_price"  name="ad_max_price" type="text" placeholder="{{Lang::get('label.Max Price')}}">
      </div>
    </div>
    <div class="formCell col6">
      <div class="form_field">
        <input class="ad_year" id="ad_year"  name="ad_year" type="text" placeholder="{{Lang::get('label.Year')}}">
      </div>
    </div>
    
    <div class="formCell col6">
      <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.Interior Color")}}</span>
          <select class="dropdown_interior_color" id="dropdown_interior_color"  name="ad_interior_color" onchange="change_dropdown_item_interior_color(this)">
            <option data-value="" >{{Lang::get("label.Interior Color")}}</option>
            @if($data->item_colors!=null && $data->item_colors!='')
                @foreach($data->item_colors as $single_color)
                  <option data-value="{{$single_color->id}}" >{!! ucfirst($single_color->color_name) !!}</option>
                @endforeach
            @endif
          </select>
      </div>
    </div>

    <div class="formCell col6">
      <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.Exterior Color")}}</span>
          <select class="dropdown_exterior_color" id="dropdown_exterior_color"  name="ad_exterior_color" onchange="change_dropdown_item_exterior_color(this)">
            <option data-value="" >{{Lang::get("label.Exterior Color")}}</option>
            @if($data->item_colors!=null && $data->item_colors!='')
                @foreach($data->item_colors as $single_color)
                  <option data-value="{{$single_color->id}}" >{!! ucfirst($single_color->color_name) !!}</option>
                @endforeach
            @endif
          </select>
      </div>
    </div>

  
    <div class="formCell col6">
        <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.Transmission")}}</span>
          <select class="dropdown_transmission" id="dropdown_transmission"  name="ad_transmission" onchange="change_dropdown_item_transmission(this)">
          
            <option data-value="" >{{Lang::get("label.Transmission")}}</option>
            @if($data->item_transmission!=null && $data->item_transmission!='')
                @foreach($data->item_transmission as $single_transmission)
                  <option data-value="{{$single_transmission->id}}" >{!! ucfirst($single_transmission->transmission_name) !!}</option>
                @endforeach
            @endif
          </select>
        </div>
    </div>
    <div class="formCell col6">
      <div class="selectbox"> 
          <span class="selectbox_span">{{Lang::get("label.Number of Cylinders")}}</span>
          <select class="dropdown_no_cylinders" id="dropdown_no_cylinders"  name="ad_no_cylinders" onchange="change_dropdown_item_no_cylinders(this)">
          
            <option data-value="" >{{Lang::get("label.Number of Cylinders")}}</option>
            @if($data->item_cylinders!=null && $data->item_cylinders!='')
                @foreach($data->item_cylinders as $single_cylinder)
                  <option data-value="{{$single_cylinder->id}}" >{!! ucfirst($single_cylinder->item_cylinder) !!}</option>
                @endforeach
            @endif
          </select>
      </div>
    </div>
