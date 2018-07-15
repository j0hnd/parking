<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">First Name <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="{{ isset($user_info->members->first_name) ? $user_info->members->first_name : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Last Name <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" autocomplete="off" value="{{ isset($user_info->members->last_name) ? $user_info->members->last_name : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email Address <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="email" placeholder="Email Address" autocomplete="off" value="{{ isset($user_info->email) ? $user_info->email : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Role <span class="required">*</span></label>

        <div class="col-sm-6">
            <select name="role_id" id="role-id" class="form-control">
                <option value="" readonly>-- Roles --</option>
                @foreach($roles as $role)
                    @if(count($user_info))
                        @if($user_info->roles[0]->id == $role->id)
                        <option value="{{ $role->id }}"selected>{{ $role->name }}</option>
                        @else
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endif
                    @else
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    @if(count($user_info))
        @php($class = ($user_info->roles[0]->slug == 'vendor') ? '' : 'hidden')
    @else
        @php($class = 'hidden')
    @endif

    <fieldset id="company-info-wrapper" class="{{ $class }}">
        <label>Company Details</label>
        <div class="form-group">
            <label class="col-sm-2 control-label">Company Name</label>

            <div class="col-sm-9">
                <select name="company[company_name]" id="company-name" class="form-control" style="width: 100%">
                    <option value="" readonly>-- Company --</option>
                    @if(count($companies))
                        @foreach($companies as $company)
                            @if(isset($user_info->members->company_id))
                                @if($user_info->members->company_id == $company->id)
                                <option value="{{ $company->id }}" selected>{{ $company->company_name }}</option>
                                @else
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                                @endif
                            @else
                            <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
                {{--<input type="text" class="form-control" name="company[company_name]" placeholder="Company Name" autocomplete="off" value="{{ isset($user_info->members->company->company_name) ? $user_info->members->company->company_name : "" }}">--}}
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>

            <div class="col-sm-9">
                <input type="text" class="form-control" name="company[email]" placeholder="Email" autocomplete="off" value="{{ isset($user_info->members->company->email) ? $user_info->members->company->email : "" }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Phone No.</label>

            <div class="col-sm-3">
                <input type="text" class="form-control" name="company[phone_no]" placeholder="Phone No." autocomplete="off" value="{{ isset($user_info->members->company->phone_no) ? $user_info->members->company->phone_no : "" }}">
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Mobile No.</label>

            <div class="col-sm-3">
                <input type="text" class="form-control" name="company[mobile_no]" placeholder="Mobile No." autocomplete="off" value="{{ isset($user_info->members->company->mobile_no) ? $user_info->members->company->mobil_no : "" }}">
            </div>
        </div>
    </fieldset>
</div>
