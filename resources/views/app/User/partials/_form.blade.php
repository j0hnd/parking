<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">First Name <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="{{ isset($user_info->members->first_name) ? $user_info->members->first_name : old('first_name') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Last Name <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" autocomplete="off" value="{{ isset($user_info->members->last_name) ? $user_info->members->last_name : old('first_name') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email Address <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="email" placeholder="Email Address" autocomplete="off" value="{{ isset($user_info->email) ? $user_info->email : old('first_name') }}">
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
        @php
            $class = ($user_info->roles[0]->slug == 'vendor' or $user_info->roles[0]->slug == 'travel_agent') ? '' : 'hidden';
        @endphp
    @else
        @php
            $class = 'hidden';
        @endphp
    @endif

    @if($user_info->roles[0]->slug == 'vendor')
        @php
            $carpark_wrapper_class = '';
            $company_wrapper_class = 'hidden';
        @endphp
    @else
        @php
            $carpark_wrapper_class = 'hidden';
            $company_wrapper_class = '';
        @endphp
    @endif

    <fieldset id="company-info-wrapper" class="{{ $class }}">
        {{--<label>Company Details</label>--}}
        <div class="form-group">
            <label class="col-sm-2 control-label">Company Name</label>

            <div id="carpark-wrapper" class="col-sm-9 {{ $carpark_wrapper_class }}">
                <select name="company[company_name]" id="company-name" class="form-control" style="width: 100%">
                    <option value="" readonly>-- Company --</option>
                    @if(isset($carparks))
                        @foreach($carparks as $carpark)
                            @if(isset($user_info->members->company_id))
                                @if($user_info->members->company_id == $carpark->id)
                                <option value="{{ $carpark->id }}" selected>{{ $carpark->name }}</option>
                                @else
                                <option value="{{ $carpark->id }}">{{ $carpark->name }}</option>
                                @endif
                            @else
                            <option value="{{ $carpark->id }}">{{ $carpark->name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>

            <div id="company-wrapper" class="col-sm-9 {{ $company_wrapper_class }}">
                <select name="company[company_name]" id="company-name" class="form-control" style="width: 100%">
                    <option value="" readonly>-- Company --</option>
                    @if(isset($companies))
                        @foreach($companies as $company)
                            @if(isset($user_info->members->company_id))
                                @if($user_info->members->company_id == $company->id)
                                    <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                                @else
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endif
                            @else
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Address</label>

            <div class="col-sm-9">
                @if(isset($user_info->members->carpark))
                    @php($carpark = $user_info->members->carpark)
                    @php($address = "{$carpark->address} {$carpark->city} {$carpark->count_state} {$carpark->zipcode}")
                @else
                    @php($address = '')
                @endif
                <input type="text" id="address" class="form-control disabled" value="{{ $address }}" readonly>
            </div>
        </div>
    </fieldset>
</div>
