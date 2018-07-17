<div class="form-group">
    <label class="col-sm-2 control-label">Carpark Name <span class="required">*</span></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" name="name" placeholder="Carpark Name" autocomplete="off" value="{{ isset($carpark->name) ? $carpark->name : old('name') }}">
    </div>
</div>

<div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Description</label>

    <div class="col-sm-9">
        <textarea name="description" class="form-control" cols="30" rows="10">{{ isset($carpark->description) ? $carpark->description : old('description') }}</textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Address <span class="required">*</span></label>

    <div class="col-sm-9">
        <input type="text" class="form-control" name="address" placeholder="Address" autocomplete="off" value="{{ isset($carpark->address) ? $carpark->address : old('address') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Address 2</label>

    <div class="col-sm-9">
        <input type="text" class="form-control" name="address2" placeholder="Address 2" autocomplete="off" value="{{ isset($carpark->address2) ? $carpark->address2 : old('address2') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">City <span class="required">*</span></label>

    <div class="col-sm-6">
        <input type="text" class="form-control" name="city" placeholder="City" autocomplete="off" value="{{ isset($carpark->city) ? $carpark->city : old('city') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">County/State <span class="required">*</span></label>

    <div class="col-sm-6">
        <input type="text" class="form-control" name="county_state" placeholder="County/State" autocomplete="off" value="{{ isset($carpark->county_state) ? $carpark->county_state : old('county_state') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Country <span class="required">*</span></label>

    <div class="col-sm-6">
        <select name="country_id" id="countries" class="form-control">
            @foreach($countries as $country)
                @if(isset($carpark))
                    @if($country->id == $carpark->country_id or $country->id == old('country_id'))
                    <option value="{{ $country->id }}" selected>{{ $country->country }}</option>
                    @else
                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                    @endif
                @else
                <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Postal Code <span class="required">*</span></label>

    <div class="col-sm-6">
        <input type="text" class="form-control" name="zipcode" placeholder="Postal Code" autocomplete="off" value="{{ isset($carpark->zipcode) ? $carpark->zipcode : old('zipcode') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Longitude</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" name="longitude" placeholder="Longitude" autocomplete="off" value="{{ isset($carpark->longitude) ? $carpark->longitude : old('longitude') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Latitude</label>

    <div class="col-sm-6">
        <input type="text" class="form-control" name="latitude" placeholder="Latitude" autocomplete="off" value="{{ isset($carpark->latitude) ? $carpark->latitude : old('latitude') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Operation Hours <span class="required">*</span></label>

    @if(isset($carpark))
        @php
            $opening = $carpark->opening;
			$closing = $carpark->closing;
        @endphp
    @else
        @php
            $opening = old('opening');
			$closing = old('closing');
        @endphp
    @endif

    @if(!empty($opening) and !empty($closing))
        @php
            $hidden_custom_time_wrapper = '';
            $checked = '';
        @endphp
    @else
        @php
            $hidden_custom_time_wrapper = 'hidden';
            $checked = 'checked';
        @endphp
    @endif

    <div id="24hrs-wrapper" class="col-sm-6">
        <label>
            <input type="checkbox" name="is_24hrs_svc" id="is-24hr" {{ $checked }} value="1"> 24hrs Service
        </label>
    </div>

    <div id="custom-time-wrapper" class="col-sm-6 {{ $hidden_custom_time_wrapper }}">
        <input type="text" id="opening" class="form-control margin-bottom5" name="opening" placeholder="Opening Hours (HH:mm)" autocomplete="off" value="{{ isset($carpark->opening) ? ($carpark->opening != "00:00:00") ? $carpark->opening : old('opening') : old('opening') }}">
        <input type="text" id="closing" class="form-control" name="closing" placeholder="Closing Hours (HH:mm)" autocomplete="off" value="{{ isset($carpark->closing) ? ($carpark->closing != "00:00:00") ? $carpark->closing : old('closing') : old('closing') }}">
        <small style="color: red;">note: time should be in 24-hour format</small>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Upload Image</label>

    <div class="col-sm-6">
        <input type="file" class="form-control margin-bottom10" name="image">
        @if(!empty($carpark->image))
        <a href="{{ URL::asset($carpark->image) }}" target="_blank">
            <img src="{{ asset($carpark->image) }}" style="max-width: 30%" alt="Carpark Image">
        </a>
        @endif
    </div>
</div>
