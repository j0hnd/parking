<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">Order Title</label>

        <div id="order-title-container-default" class="col-sm-9">
        @if(isset($booking))
            @php
                $order_id = $booking->product_id.";".$booking->price_id.";".$booking->products[0]->airport[0]->id;
                $order_title = $booking->products[0]->airport[0]->airport_name.' - '.$booking->products[0]->carpark->name.' - '.$booking->products[0]->prices[0]->categories->category_name.' [No of days '.$booking->products[0]->prices[0]->no_of_days.' - £'.$booking->products[0]->prices[0]->price_value.']';
            @endphp
            <input type="text" class="form-control" value="{{ $order_title }}" readonly>
        @endif
        </div>

        <div id="order-title-container-edit" class="col-sm-9 hidden">
            <select class="form-control" id="order-title" name="order_title" style="width:100%">
                <option value="" readonly>-- Order Title --</option>
                @if(!is_null($products_list))
                    @foreach($products_list as $product)
                        @if(isset($booking))
                            @php
                                $order_id = $booking->product_id.";".$booking->price_id.";".$booking->products[0]->airport[0]->id;
                            @endphp

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
        <label class="col-sm-2 control-label">Dparture Terminal</label>

        <div class="col-sm-9">
            <select name="departure_terminal" id="departure-terminal" class="form-control">
                <option value="" readonly>-- Terminals --</option>
            </select>
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
        <label class="col-sm-2 control-label">Arrival Terminal</label>

        <div class="col-sm-9">
            <select name="arrival_terminal" id="arrival-terminal" class="form-control">
                <option value="" readonly>-- Terminals --</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Car Registration No.</label>

        <div class="col-sm-9">
            <input type="text" class="form-control"
                   name="car_registration_no"
                   placeholder="Car Registration No."
                   autocomplete="off"
                   value="{{ isset($booking) ? $booking->car_registration_no : '' }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Vehicle Make</label>

        <div class="col-sm-9">
            @if(isset($booking))
                @if(in_array($booking->vehicle_make, $vehicle_make_name) == true)
                <select class="form-control" id="vehicle-make" name="vehicle_make">
                    <option value="" readonly>-- Vehicle Make --</option>
                    @if(count($vehicle_make))
                        @foreach($vehicle_make as $i => $vm)
                            @if(isset($booking))
                                @if($booking->vehicle_make == $vm['title'])
                                    <option value="{{ $vm['title'] }}" data-index="{{ $i }}" selected>{{ $vm['title'] }}</option>
                                @else
                                    <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                                @endif
                            @else
                                <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                            @endif

                        @endforeach
                        <option value="-1" data-index="-1">Other Vehicle Make</option>
                    @endif
                </select>
                <input type="text" class="form-control hidden" id="other-vehicle-make" placeholder="Vehicle Make" name="other_vehicle_make" value="" autocomplete="off">
                @else
                    <select class="form-control" id="vehicle-make" name="vehicle_make">
                        <option value="" readonly>-- Vehicle Make --</option>
                        @if(count($vehicle_make))
                            @foreach($vehicle_make as $i => $vm)
                                @if(isset($booking))
                                    @if($booking->vehicle_make == $vm['title'])
                                        <option value="{{ $vm['title'] }}" data-index="{{ $i }}" selected>{{ $vm['title'] }}</option>
                                    @else
                                        <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                                    @endif
                                @else
                                    <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                                @endif

                            @endforeach
                            <option value="-1" data-index="-1">Other Vehicle Make</option>
                        @endif
                    </select>
                    <input type="text" class="form-control hidden" id="other-vehicle-make" placeholder="Vehicle Make" name="other_vehicle_make" value="" autocomplete="off">
                @endif
            @else
            <select class="form-control" id="vehicle-make" name="vehicle_make">
                <option value="" readonly>-- Vehicle Make --</option>
                @if(count($vehicle_make))
                    @foreach($vehicle_make as $i => $vm)
                        @if(isset($booking))
                            @if($booking->vehicle_make == $vm['title'])
                            <option value="{{ $vm['title'] }}" data-index="{{ $i }}" selected>{{ $vm['title'] }}</option>
                            @else
                            <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                            @endif
                        @else
                            <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                        @endif

                    @endforeach
                    <option value="-1" data-index="-1">Other Vehicle Make</option>
                @endif
            </select>
            <input type="text" class="form-control hidden" id="other-vehicle-make" placeholder="Vehicle Make" name="other_vehicle_make" value="" autocomplete="off">
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Vehicle Model</label>

        <div class="col-sm-9">
            @if(isset($booking))
                @if(in_array($booking->vehicle_model, $vehicle_make_name) == true)
                <select class="form-control" name="vehicle_model" id="vehicle-model">
                    <option value="" readonly> -- Vehicle Model -- </option>
                    @if(isset($booking))
                        @foreach($vehicle_models as $model)
                            @if($model['value'] == $booking->vehicle_model)
                            <option value="{{ $model['title'] }}" selected>{{ $model['title'] }}</option>
                            @else
                            <option value="{{ $model['title'] }}">{{ $model['title'] }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                @else
                    @if(empty($booking->vehicle_model))
                    <select class="form-control" name="vehicle_model" id="vehicle-model">
                        <option value="" readonly> -- Vehicle Model -- </option>
                        @if(isset($booking))
                            @foreach($vehicle_models as $model)
                                @if($model['value'] == $booking->vehicle_model)
                                <option value="{{ $model['title'] }}" selected>{{ $model['title'] }}</option>
                                @else
                                <option value="{{ $model['title'] }}">{{ $model['title'] }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    <input type="text" class="form-control hidden" id="other-vehicle-model" placeholder="Vehicle Model" name="other_vehicle_model" autocomplete="off">
                    @else
                    <select class="form-control hidden" name="vehicle_model" id="vehicle-model">
                        <option value="" readonly> -- Vehicle Model -- </option>
                        @if(isset($booking))
                            @foreach($vehicle_models as $model)
                            <option value="{{ $model['title'] }}">{{ $model['title'] }}</option>
                            @endforeach
                        @endif
                    </select>
                    <input type="text" class="form-control" id="other-vehicle-model" placeholder="Vehicle Model" name="other_vehicle_model" value="{{ $booking->vehicle_model }}" autocomplete="off">
                    @endif
                @endif
            @else
            <select class="form-control hidden" name="vehicle_model" id="vehicle-model">
                <option value="" readonly> -- Vehicle Model -- </option>
                @if(isset($booking))
                    @foreach($vehicle_models as $model)
                    <option value="{{ $model['value'] }}">{{ $model['title'] }}</option>
                    @endforeach
                @endif
            </select>
            <input type="text" class="form-control" id="other-vehicle-model" placeholder="Vehicle Model" name="other_vehicle_model" autocomplete="off">
            @endif
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

    @if(!isset($booking))
    <div class="form-group">
        <label class="col-sm-2 control-label">Total Value (£)</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="price-value" name="price_value"
                   placeholder="Price Value"
                   value="{{ isset($booking) ? $booking->price_value : "" }}"
                   autocomplete="off">
        </div>
    </div>

    @if($user->roles[0]->slug == 'administrator')
    <div class="form-group">
        <label class="col-sm-2 control-label">MTC Revenue (£)</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" id="revenue-share" name="revenue_value"
                   placeholder="Revenue Value"
                   autocomplete="off"
                   value="{{ isset($booking) ? $booking->revenue_value : "" }}"
                   readonly>
        </div>
    </div>
    @endif
    @endif

    @php
        if (isset($booking)) {
            $readonly = true;
        } else {
            $readonly = false;
        }
    @endphp

    <div class="form-group">
        <label class="col-sm-2 control-label">Drop Off:</label>

        <div id="drop-off-container-default" class="col-sm-5">
            @if($readonly)
            <input type="text" class="form-control"
                   placeholder="Drop Off"
                   value="{{ $booking->drop_off_at->format('d/m/Y') }}"
                   readonly
                   autocomplete="off">

            <div class="input-group bootstrap-timepicker timepicker">
                <input type="text" class="form-control input-small" value="{{ $booking->drop_off_at->format('h:i A') }}" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            @endif
        </div>

        <div id="drop-off-container-edit" class="col-sm-5 hidden">
            <input type="text" id="drop-off-date" class="form-control" name="drop_off_date"
                   placeholder="Drop Off"
                   value="{{ isset($booking) ? $booking->drop_off_at->format('d/m/Y') : "" }}"
                   autocomplete="off">

            <div class="input-group bootstrap-timepicker timepicker">
                <input id="drop-off-time" type="text" name="drop_off_time" class="form-control input-small" value="{{ isset($booking) ? $booking->drop_off_at->format('h:i A') : "" }}">
                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Return Date</label>

        <div id="return-at-container-default" class="col-sm-5">
            @if($readonly)
            <input type="text" class="form-control"
                   placeholder="Return Date"
                   value="{{ $booking->return_at->format('d/m/Y') }}"
                   readonly
                   autocomplete="off">

            <div class="input-group bootstrap-timepicker timepicker">
               <input type="text" class="form-control input-small" value="{{ $booking->return_at->format('h:i A') }}" readonly>
               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
            @endif
        </div>

        <div id="return-at-container-edit" class="col-sm-5 hidden">
            <input type="text" id="return-at-date" class="form-control" name="return_at_date"
                   placeholder="Return Date"
                   value="{{ isset($booking) ? $booking->return_at->format('d/m/Y') : "" }}"
                   autocomplete="off">

            <div class="input-group bootstrap-timepicker timepicker">
               <input id="return-at-time" type="text" class="form-control input-small" name="return_at_time" value="{{ isset($booking) ? $booking->return_at->format('h:i A') : "" }}">
               <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">No of Passengers:</label>

        <div class="col-sm-5">
            <input type="number" id="no-of-passengers" class="form-control" name="no_of_passengers"
                   placeholder="No of Passengers"
                   value="{{ isset($booking->booking_details->no_of_passengers_in_vehicle) ? $booking->booking_details->no_of_passengers_in_vehicle : '' }}"
                   autocomplete="off">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        @php($checked = '')

        @if(isset($booking->booking_details->with_oversize_baggage))
            @if($booking->booking_details->with_oversize_baggage > 0)
                @php($checked = 'checked')
            @endif
        @endif

        <div class="col-sm-5 checkbox">
            <label>
                <input type="checkbox" {{ $checked }} name="with_oversize_baggage"> Travelling with sports or oversize baggage
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">&nbsp;</label>

        @php($checked = '')

        @if(isset($booking->booking_details->with_children_pwd))
            @if($booking->booking_details->with_children_pwd > 0)
                @php($checked = 'checked')
            @endif
        @endif

        <div class="col-sm-5 checkbox">
            <label>
                <input type="checkbox" {{ $checked }} name="with_children_pwd"> Travelling with children or disabled passengers
            </label>
        </div>
    </div>

    @if(isset($booking))
    <div class="form-group">
        <label class="col-sm-2 control-label">Date Posted:</label>

        <div class="col-sm-5">
            <input type="text" class="form-control" readonly value="{{ $booking->created_at->format('d/m/Y') }}">
        </div>
    </div>
    @endif
</div>
