<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">Order Title</label>

        <div class="col-sm-9">
            <select class="form-control" id="order-title" name="order_title">
                <option value="" readonly>-- Order Title --</option>
                @if(!is_null($products_list))
                    @foreach($products_list as $product)
                    <option value="{{ $product['order_id'] }}">{{ $product['product_name'] }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Flight No. <small>(Departure)</small> </label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="flight_no_going" placeholder="Flight No." autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Flight No. <small>(Arrival)</small> </label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="flight_no_return" placeholder="Flight No." autocomplete="off">
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
            <input type="text" class="form-control" name="vehicle_make" placeholder="Vehicle Make" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Model</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="car_model" placeholder="Model" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Price Value (£)</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="price-value" name="price_value" placeholder="Price Value" autocomplete="off">
        </div>
    </div>

    @if($user->roles[0]->slug == 'administrator')
    <div class="form-group">
        <label class="col-sm-2 control-label">Revenue Value (£)</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="revenue-share" name="revenue_value" placeholder="Revenue Value" autocomplete="off" readonly>
        </div>
    </div>
    @endif

    <div class="form-group">
        <label class="col-sm-2 control-label">Drop Off:</label>

        <div class="col-sm-5">
            <input type="text" id="drop-off-at" class="form-control" name="drop_off_at" placeholder="Drop Off" autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Return Date</label>

        <div class="col-sm-5">
            <input type="text" id="return-at" class="form-control" name="return_at" placeholder="Return Date" autocomplete="off">
        </div>
    </div>
</div>
