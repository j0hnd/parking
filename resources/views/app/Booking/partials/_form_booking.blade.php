<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">Order Title</label>

        <div class="col-sm-9">
            <select class="form-control" id="order-title" name="order_title">
                <option value="" readonly>-- Order Title --</option>
                @if(!is_null($products_list))
                    @foreach($products_list as $product)
                        @if(isset($booking))
                            @php($order_id = $booking->product_id.";".$booking->price_id)
                            @if($order_id == $product['order_id'])
                            <option value="{{ $product['order_id'] }}" selected>{{ $product['product_name'] }}</option>
                            @else
                            <option value="{{ $product['order_id'] }}">{{ $product['product_name'] }}</option>
                            @endif
                        @else
                        <option value="{{ $product['order_id'] }}">{{ $product['product_name'] }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Flight No. <small>(Departure)</small> </label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="flight_no_going"
                   placeholder="Flight No."
                   value="{{ isset($booking) ? $booking->flight_no_going : "" }}"
                   autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Flight No. <small>(Arrival)</small> </label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="flight_no_return"
                   placeholder="Flight No."
                   value="{{ isset($booking) ? $booking->flight_no_return : "" }}"
                   autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Car Registration No.</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="car_registration_no" placeholder="Car Registration No." autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Vehicle Make</label>

        <div class="col-sm-9">
            <select class="form-control" id="vehicle-make" name="vehicle_make">
                <option value="" readonly>-- Vechile Make --</option>
                @if(count($vehicle_make))
                    @foreach($vehicle_make as $i => $vm)
                        @if(isset($booking))
                            @if($booking->vehicle_make == $vm['value'])
                            <option value="{{ $vm['value'] }}" data-index="{{ $i }}" selected>{{ $vm['title'] }}</option>
                            @else
                            <option value="{{ $vm['value'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                            @endif
                        @else
                        <option value="{{ $vm['value'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                        @endif

                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Vehicle Model</label>

        <div class="col-sm-9">
            <select class="form-control" name="vehicle_model" id="vehicle-model">
                @if(isset($booking))
                    @foreach($vehicle_models as $model)
                        @if($model['value'] == $booking->vehicle_model)
                        <option value="{{ $model['value'] }}" selected>{{ $model['title'] }}</option>
                        @else
                        <option value="{{ $model['value'] }}">{{ $model['title'] }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Vehicle Color</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" name="vehicle_color"
                   placeholder="Vehicle Color"
                   value="{{ isset($booking) ? $booking->vehicle_color : "" }}"
                   autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Price Value (£)</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="price-value" name="price_value"
                   placeholder="Price Value"
                   value="{{ isset($booking) ? $booking->price_value : "" }}"
                   autocomplete="off">
        </div>
    </div>

    @if($user->roles[0]->slug == 'administrator')
    <div class="form-group">
        <label class="col-sm-2 control-label">Revenue Value (£)</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="revenue-share" name="revenue_value"
                   placeholder="Revenue Value"
                   autocomplete="off"
                   value="{{ isset($booking) ? $booking->revenue_value : "" }}"
                   readonly>
        </div>
    </div>
    @endif

    <div class="form-group">
        <label class="col-sm-2 control-label">Drop Off:</label>

        <div class="col-sm-5">
            <input type="text" id="drop-off-date" class="form-control" name="drop_off_date"
                   placeholder="Drop Off"
                   value=""
                   autocomplete="off">

            <div class="input-group bootstrap-timepicker timepicker">
                <input id="drop-off-time" type="text" class="form-control input-small" name="drop_off_time">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Return Date</label>

        <div class="col-sm-5">
            <input type="text" id="return-at-date" class="form-control" name="return_at_date"
                   placeholder="Return Date"
                   value="{{ isset($booking) ? $booking->return_at->format('m/d/Y') : "" }}"
                   autocomplete="off">

            <div class="input-group bootstrap-timepicker timepicker">
               <input id="return-at-time" type="text" class="form-control input-small" name="return_at_time">
               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        </div>
    </div>
</div>
