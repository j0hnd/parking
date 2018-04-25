<div class="form-group">
    <label class="col-sm-2 control-label">Services</label>

    <div class="col-sm-9">
    @if($carparkServices->count())
        @foreach($carparkServices->get() as $service)
            @if(isset($selectedServices[$service->id]))
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" checked>
                    {{ $service->service_name }}
                </label>
            </div>
            @else
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}">
                    {{ $service->service_name }}
                </label>
            </div>
            @endif
        @endforeach
    @endif
    </div>
</div>