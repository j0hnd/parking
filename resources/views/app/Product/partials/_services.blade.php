<div class="form-group">
    <label class="col-sm-2 control-label">Services</label>

    <div class="col-sm-9">
    @if($carparkServices->count())
        @foreach($carparkServices->get() as $service)
        <div class="checkbox">
            <label>
                <input type="checkbox" name="services[]" value="{{ $service->id }}">
                {{ $service->service_name }}
            </label>
        </div>
        @endforeach
    @endif
    </div>
</div>