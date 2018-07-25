<div class="form-group">
    <label class="col-sm-2 control-label">Carpark <span class="required">*</span></label>

    <div class="col-sm-9">
        <select name="carpark_id" id="carpark-id" class="form-control">
            <option value="" readonly>-- Carpark -- </option>
            @if($carparks->count())
                @foreach($carparks->get() as $carpark)
                    @if(isset($product))
                        @if($product->carpark_id == $carpark->id)
                        <option value="{{ $carpark->id }}" selected>{{ $carpark->name }}</option>
                        @else
                        <option value="{{ $carpark->id }}">{{ $carpark->name }}</option>
                        @endif
                    @else
                    <option value="{{ $carpark->id }}" {{ (old('carpark_id') == $carpark->id ? "selected":"") }}>{{ $carpark->name }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Airport</label>

    <div class="col-sm-9">
        <select name="airport_id[]" id="airport-id" class="form-control" multiple="multiple">
            @if($airports->count())
                @foreach($airports->get() as $airport)
                    @if(isset($product->airport))
                        @foreach($product->airport as $product_airport)
                            @if($airport->id == $product_airport->id or $airport->id == old('airport_id'))
                            <option value="{{ $airport->id }}" selected>{{ $airport->airport_name }}</option>
                            @else
                            <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                            @endif
                        @endforeach
                    @else
                    <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Short Description <span class="required">*</span></label>

    <div class="col-sm-9">
        <input type="text" name="short_description" class="form-control" autocomplete="off" value="{{ isset($product) ? $product->short_description : old('short_description') }}">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Description</label>

    <div class="col-sm-9">
        <textarea name="description" id="description" class="form-control" cols="30" rows="10">
            @if(isset($product))
            {{ $product->description }}
            @else
            {{ old('description') }}
            @endif
        </textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">On Arrival</label>

    <div class="col-sm-9">
        <textarea name="on_arrival" id="on_arrival" class="form-control" cols="30" rows="10">
            @if(isset($product))
            {{ $product->on_arrival }}
            @else
            {{ old('on_arrival') }}
            @endif
        </textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">On Return</label>

    <div class="col-sm-9">
        <textarea name="on_return" id="on_return" class="form-control" cols="30" rows="10">
            @if(isset($product))
            {{ $product->on_return }}
            @else
            {{ old('on_return') }}
            @endif
        </textarea>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Directions </label>

    <div class="col-sm-9">
        <input type="text" class="form-control" name="directions" value="{{ isset($product) ? $product->directions : old('directions') }}" autocomplete="off">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">Revenue Share <span class="required">*</span></label>

    <div class="col-sm-5">
        <input type="text" class="form-control" name="revenue_share" value="{{ isset($product) ? $product->revenue_share : old('revenue_share') }}" autocomplete="off">
    </div>
</div>
