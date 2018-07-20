<div class="row">
    <div class="search-container {{ (isset($booking->customers)) ? "hidden" : "" }}">
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-sm-2 control-label">Search Customer</label>

                <div class="col-sm-10">
                    <select class="form-control" id="search-customer">
                        <option value="" readonly></option>
                        @if($customers->count())
                            @foreach ($customers->get() as $customer) {
                            <option value="{{ $customer->id }}">{{ $customer->last_name }}, {{ $customer->first_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-sm-9 pull-right margin-top10">
                    <button type="button" id="toggle-new-customer" class="btn btn-link pull-right">New Customer</button>
                </div>
            </div>
        </div>
    </div>

    <div class="new-customer-container {{ (isset($booking->customers)) ? "" : "hidden" }}">
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-sm-2 control-label">First Name</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="first-name"
                           name="first_name"
                           placeholder="First Name"
                           value="{{ isset($booking->customers) ? $booking->customers->first_name : "" }}"
                           autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Last Name</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="last-name"
                           name="last_name"
                           placeholder="Last Name"
                           value="{{ isset($booking->customers) ? $booking->customers->last_name : "" }}"
                           autocomplete="off">
                </div>
            </div>

            @if(!isset($booking))
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Address</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="email"
                           name="email"
                           placeholder="Email Address"
                           value="{{ isset($booking->customers) ? $booking->customers->email : "" }}"
                           autocomplete="off">
                </div>
            </div>
            @endif

            <div class="form-group">
                <label class="col-sm-2 control-label">Mobile No.</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" id="mobile-no"
                           name="mobile_no"
                           placeholder="Mobile No."
                           value="{{ isset($booking->customers) ? $booking->customers->mobile_no : "" }}"
                           autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-xs-12 pull-right margin-top10">
            <button type="button" id="toggle-show-search" class="btn btn-link pull-right">Hide Form</button>
        </div>
    </div>
</div>
