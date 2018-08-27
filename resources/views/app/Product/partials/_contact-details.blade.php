<div class="form-group">
    <label class="col-sm-3 control-label">Name <span class="required">*</span></label>

    <div class="col-sm-8">
        <input type="text" class="form-control"
               name="contact_person_name"
               placeholder="Name"
               autocomplete="off"
               value="{{ isset($product->contact_details) ? $product->contact_details->contact_person_name : old('contact_person_name') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Email <span class="required">*</span></label>

    <div class="col-sm-8">
        <input type="text" class="form-control"
               name="contact_person_email"
               placeholder="Email"
               autocomplete="off"
               value="{{ isset($product->contact_details) ? $product->contact_details->contact_person_email : old('contact_person_email') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Phone No./Mobile No. <span class="required">*</span></label>

    <div class="col-sm-5">
        <input type="text" class="form-control"
               name="contact_person_phone_no"
               placeholder="Contact No."
               autocomplete="off"
               value="{{ isset($product->contact_details) ? $product->contact_details->contact_person_phone_no : old('contact_person_phone_no') }}">
    </div>
</div>
