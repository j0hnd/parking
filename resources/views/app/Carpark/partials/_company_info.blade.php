<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label class="col-sm-3 control-label">Company Name <span class="required">*</span></label>

            <div id="company-name-wrapper" class="col-sm-8">
                <input type="text" class="form-control"
                       id="company-name"
                       name="company_name"
                       placeholder="Company Name"
                       autocomplete="off"
                       value="{{ isset($carpark) ? $carpark->company->company_name : old('company_name') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Email <span class="required">*</span></label>

            <div class="col-sm-8">
                <input type="text" class="form-control"
                       name="email"
                       placeholder="Email"
                       autocomplete="off"
                       value="{{ isset($carpark) ? $carpark->company->email : old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Phone No.</label>

            <div class="col-sm-5">
                <input type="text" class="form-control"
                       name="phone_no"
                       placeholder="Phone No."
                       autocomplete="off"
                       value="{{ isset($carpark) ? $carpark->company->phone_no : old('phone_no') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Mobile No.</label>

            <div class="col-sm-5">
                <input type="text" class="form-control"
                       name="mobile_no"
                       placeholder="Mobile No."
                       autocomplete="off"
                       value="{{ isset($carpark) ? $carpark->company->mobile_no : old('mobile_no') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">VAT No.</label>

            <div class="col-sm-5">
                <input type="text" class="form-control"
                       name="vat_no"
                       placeholder="VAT No."
                       autocomplete="off"
                       value="{{ isset($carpark) ? $carpark->company->vat_no : old('vat_no') }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label">Company Registration</label>

            <div class="col-sm-5">
                <input type="text" class="form-control"
                       name="company_reg"
                       placeholder="Company Registration"
                       autocomplete="off"
                       value="{{ isset($carpark) ? $carpark->company->company_reg : old('company_reg') }}">
            </div>
        </div>

        <fieldset>
            <h4>Documents</h4>
            <p class="bg-warning padding-10 text-center">Supported files: JPEG, JPG, PNG, GIF and PDF</p>
            <div class="form-group">
                <label class="col-sm-3 control-label">Insurance Policy</label>

                <div class="col-sm-5">
                    <input type="file" class="form-control margin-bottom10" name="insurance_policy">
                    @if(!empty($carpark->company->insurance_policy))
                        @php($file_type = explode('.', $carpark->company->insurance_policy))
                        <a href="{{ URL::asset($carpark->company->insurance_policy) }}" target="_blank">
                            @if($file_type[1] == 'pdf')
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            @else
                            <img src="{{ asset($carpark->company->insurance_policy) }}" style="max-width: 30%" alt="Carpark Image">
                            @endif
                        </a>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">Park Mark</label>

                <div class="col-sm-5">
                    <input type="file" class="form-control margin-bottom10" name="park_mark">
                    @if(!empty($carpark->company->park_mark))
                    <a href="{{ URL::asset($carpark->company->park_mark) }}" target="_blank" >
                        @php($file_type = explode('.', $carpark->company->park_mark))
                        @if($file_type[1] == 'pdf')
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                        @else
                        <img src="{{ asset($carpark->company->park_mark) }}" style="max-width: 30%" alt="Carpark Image">
                        @endif
                    </a>
                    @endif
                </div>
            </div>
        </fieldset>
    </div>

    <div class="col-md-5">
        <h4 class="bg-info padding-10 text-center">Company Details</h4>
        @if(isset($carpark))
            @if(count($carpark->company->company_details))
                @foreach($carpark->company->company_details as $details)
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{ ucwords(str_replace('_', ' ', $details['meta_key'])) }}</label>

                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ $details['meta_value'] }}" disabled>
                    </div>
                </div>
                @endforeach
            @else
            <p>No details pulled from third party tool</p>
            @endif
        @else
        <p>No details pulled from third party tool</p>
        @endif
    </div>
</div>
