<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">Carpark Name</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="name" placeholder="Carpark Name" autocomplete="off" value="{{ isset($carpark->name) ? $carpark->name : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Description</label>

        <div class="col-sm-9">
            <textarea name="description" class="form-control" cols="30" rows="10">{{ isset($carpark->description) ? $carpark->description : "" }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Address</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="address" placeholder="Address" autocomplete="off" value="{{ isset($carpark->address) ? $carpark->address : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Address 2</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="address2" placeholder="Address 2" autocomplete="off" value="{{ isset($carpark->address2) ? $carpark->address2 : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">City</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="city" placeholder="City" autocomplete="off" value="{{ isset($carpark->city) ? $carpark->city : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">County/State</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="county_state" placeholder="County/State" autocomplete="off" value="{{ isset($carpark->county_state) ? $carpark->county_state : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Country</label>

        <div class="col-sm-6">
            <select name="country_id" id="countries" class="form-control">
                <option value="">-- Country --</option>
                @foreach($countries as $country)
                    @if(isset($carpark))
                        @if($country->id == $carpark->country_id)
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
        <label class="col-sm-2 control-label">Postal Code</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="zipcode" placeholder="Postal Code" autocomplete="off" value="{{ isset($carpark->zipcode) ? $carpark->zipcode : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Longitude</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="longitude" placeholder="Longitude" autocomplete="off" value="{{ isset($carpark->longitude) ? $carpark->longitude : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Latitude</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="latitude" placeholder="Latitude" autocomplete="off" value="{{ isset($carpark->latitude) ? $carpark->latitude : "" }}">
        </div>
    </div>
</div>