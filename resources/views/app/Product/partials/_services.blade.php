<div class="form-group">
    <label class="col-sm-2 control-label">Services</label>

    <div class="col-sm-9">
    @if($carparkServices->count())
        @foreach($carparkServices->get() as $service)
            @if(isset($selectedServices[$service->id]))
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" checked>
                    <a href="#"><i class="fa {{ $service->icon }}"></i></a>
                    {{ $service->service_name }}
                </label>
            </div>
            @else
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}">
                    <a href="#"><i class="fa {{ $service->icon }} margin-right5 margin-left5"></i></a>
                    {{ $service->service_name }}
                </label>
            </div>
            @endif
        @endforeach
    @endif
    </div>
</div>
