<div class="form-group">
    <label class="col-sm-2 control-label">Company Name</label>

    <div class="col-sm-9">
        <input type="text" class="form-control" name="company_name" placeholder="Company Name" autocomplete="off" value="{{ isset($carpark) ? $carpark->company->company_name : "" }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Email</label>

    <div class="col-sm-5">
        <input type="text" class="form-control" name="email" placeholder="Email" autocomplete="off" value="{{ isset($carpark) ? $carpark->company->email : "" }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Phone No.</label>

    <div class="col-sm-5">
        <input type="text" class="form-control" name="phone_no" placeholder="Phone No." autocomplete="off" value="{{ isset($carpark) ? $carpark->company->phone_no : "" }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Mobile No.</label>

    <div class="col-sm-5">
        <input type="text" class="form-control" name="mobile_no" placeholder="Mobile No." autocomplete="off" value="{{ isset($carpark) ? $carpark->company->mobile_no : "" }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">VAT No.</label>

    <div class="col-sm-5">
        <input type="text" class="form-control" name="vat_no" placeholder="VAT No." autocomplete="off" value="{{ isset($carpark) ? $carpark->company->vat_no : "" }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Company Registration</label>

    <div class="col-sm-5">
        <input type="text" class="form-control" name="company_reg" placeholder="Company Registration" autocomplete="off" value="{{ isset($carpark) ? $carpark->company->company_reg : "" }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Insurance Policy</label>

    <div class="col-sm-5">
        <input type="file" class="form-control margin-bottom10" name="insurance_policy">
        <small>Upload image of insurance policy</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Park Mark</label>

    <div class="col-sm-5">
        <input type="file" class="form-control margin-bottom10" name="park_mark">
        <small>Upload image of park mark</small>
    </div>
</div>
