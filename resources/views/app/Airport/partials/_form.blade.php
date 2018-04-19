<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">Airport Name</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="airport_name" placeholder="Airport Name" autocomplete="off" value="{{ isset($airport->airport_name) ? $airport->airport_name : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Description</label>

        <div class="col-sm-9">
            <textarea name="description" class="form-control" cols="30" rows="10">{{ isset($airport->description) ? $airport->description : "" }}</textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Address</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="address" placeholder="Address" autocomplete="off" value="{{ isset($airport->address) ? $airport->address : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Address 2</label>

        <div class="col-sm-9">
            <input type="text" class="form-control" name="address2" placeholder="Address 2" autocomplete="off" value="{{ isset($airport->address2) ? $airport->address2 : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">City</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="city" placeholder="City" autocomplete="off" value="{{ isset($airport->city) ? $airport->city : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">County/State</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="county_state" placeholder="County/State" autocomplete="off" value="{{ isset($airport->county_state) ? $airport->county_state : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Country</label>

        <div class="col-sm-6">
            <select name="country_id" id="countries" class="form-control">
                <option value="">-- Country --</option>
                @foreach($countries as $country)
                    @if(isset($airport))
                        @if($country->id == $airport->country_id)
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
            <input type="text" class="form-control" name="zipcode" placeholder="Postal Code" autocomplete="off" value="{{ isset($airport->zipcode) ? $airport->zipcode : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Longitude</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="longitude" placeholder="Longitude" autocomplete="off" value="{{ isset($airport->longitude) ? $airport->longitude : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Latitude</label>

        <div class="col-sm-6">
            <input type="text" class="form-control" name="latitude" placeholder="Latitude" autocomplete="off" value="{{ isset($airport->latitude) ? $airport->latitude : "" }}">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Sub-Category</label>

        <div class="col-sm-6">
            <select name="subcategory" id="subcategory" class="form-control"></select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Upload Image</label>

        <div class="col-sm-6">
            <input type="file" class="form-control" name="image">
        </div>
    </div>
</div>