<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">First Name <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="first_name" placeholder="First Name" autocomplete="off" value="{{ isset($user->members->first_name) ? $user->members->first_name : old('first_name') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Last Name <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="last_name" placeholder="Last Name" autocomplete="off" value="{{ isset($user->members->last_name) ? $user->members->last_name : old('first_name') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Email Address <span class="required">*</span></label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="email" placeholder="Email Address" autocomplete="off" value="{{ isset($user->email) ? $user->email : old('first_name') }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Role <span class="required">*</span></label>

        <div class="col-sm-6">
            <select name="role_id" id="role-id" class="form-control">
                <option value="" readonly>-- Roles --</option>
                @foreach($roles as $role)
                    @if(count($user))
                        @if($user->roles[0]->id == $role->id)
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

    @if(count($user))
        @php
            $class = ($user->roles[0]->slug == 'vendor' or $user->roles[0]->slug == 'travel_agent') ? '' : 'hidden';
        @endphp
    @else
        @php
            $class = 'hidden';
        @endphp
    @endif

    @if(count($user))
        @if($user->roles[0]->slug == 'vendor')
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
    @else
        @php
            $carpark_wrapper_class = '';
            $company_wrapper_class = 'hidden';
        @endphp
    @endif

    <fieldset id="company-info-wrapper" class="{{ $class }}">
        {{--<label>Company Details</label>--}}
        <div class="form-group">
            <label class="col-sm-2 control-label">Company Name</label>

            <div id="carpark-wrapper" class="col-sm-9 {{ $carpark_wrapper_class }}">
                <select name="company[company_name]" id="carpark-name" class="form-control" style="width: 100%">
                    <option value="" readonly>-- Company --</option>
                    @if(isset($carparks))
                        @foreach($carparks as $carpark)
                            @if(isset($user->members->company_id))
                                @if($user->members->company_id == $carpark->id)
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
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Address</label>

            <div class="col-sm-9">
                @if(isset($user->members->carpark))
                    @php($carpark = $user->members->carpark)
                    @php($address = "{$carpark->address} {$carpark->city} {$carpark->count_state} {$carpark->zipcode}")
                @else
                    @php($address = '')
                @endif
                <input type="text" id="address" class="form-control disabled" value="{{ $address }}" readonly>
            </div>
        </div>
    </fieldset>
</div>
