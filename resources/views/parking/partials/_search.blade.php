<form action="{{ url('/search') }}" method="post">
    <div class="row book-box">
        <div class="col-md-3 input1">
            <i><img src="{{ asset('/img/plane-mini.png') }}"></i> Airport <br/>
            <select class="form-control-sm" style="width:100%">
                <option value="" readonly>-- Airports --</option>
                @if(count($airports))
                    @foreach($airports as $airport)
                    <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-2 input2">
            <i><img src="{{ asset('/img/calendar.png') }}"></i> Drop off <br/>
            <input type='text' name="search[drop-off-date]" class="form-control-sm datepicker" placeholder="mm/dd/yyyy" value="{{ date('m/d/Y') }}"></input>
        </div>
        <div class="col-md-1 input3">
            <br>
            <select class="form-control-sm" name="search[drop-off-time]">{!! $time_intervals !!}</select>
        </div>
        <div class="col-md-2 input4">
            <i><img src="{{ asset('img/calendar.png') }}"></i> Return at <br/>
            <input type='text' name="search[return-at-date]" class="form-control-sm datepicker" placeholder="mm/dd/yyyy" value="{{ date('m/d/Y') }}"></input>
        </div>
        <div class="col-md-1 input5">
            <br>
            <select class="form-control-sm" name="search[return-at-time]">{!! $time_intervals !!}</select>
        </div>
        <div class="col-md-3 input6">
            <button type="submit" class="btn btn-primary btn-sm"><i><img src="{{ asset('/img/search.png') }}"/></i> Search Car Park</button>
        </div>
    </div>
    {{ csrf_field() }}
</form>
