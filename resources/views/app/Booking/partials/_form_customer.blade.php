<div class="row">
    <div class="search-container">
        <div class="col-xs-12">
            <div class="input-group input-group-sm">
                <input type="text" name="search" class="form-control pull-right" placeholder="Search Customer">

                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div>

        <div class="col-xs-12 pull-right margin-top10">
            <button type="button" id="toggle-new-customer" class="btn btn-link pull-right">New Customer</button>
        </div>
    </div>

    <div class="new-customer-container hidden">
        <div class="col-xs-12">
            <div class="form-group">
                <label class="col-sm-2 control-label">First Name</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Last Name</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" name="last_name" placeholder="Last Name" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Email Address</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" name="email" placeholder="Email Address" autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Mobile No.</label>

                <div class="col-sm-9">
                    <input type="text" class="form-control" name="mobile_no" placeholder="Mobile No." autocomplete="off">
                </div>
            </div>
        </div>

        <div class="col-xs-12 pull-right margin-top10">
            <button type="button" id="toggle-show-search" class="btn btn-link pull-right">Hide Form</button>
        </div>
    </div>
</div>
