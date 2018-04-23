<div class="box-body">
    <div class="form-group">
        <label class="col-sm-2 control-label">Carpark</label>

        <div class="col-sm-9">
            <select name="carpark_id" id="carpark-id" class="form-control">
            @if($carparks->count())
                @foreach($carparks->get() as $carpark)
                <option value="{{ $carpark->id }}">{{ $carpark->name }}</option>
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
                <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                @endforeach
            @endif
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Description</label>

        <div class="col-sm-9">
            <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">On Arrival</label>

        <div class="col-sm-9">
            <textarea name="on_arrival" id="on_arrival" class="form-control" cols="30" rows="10"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">On Return</label>

        <div class="col-sm-9">
            <textarea name="on_return" id="on_return" class="form-control" cols="30" rows="10"></textarea>
        </div>
    </div>
</div>