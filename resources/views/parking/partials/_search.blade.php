<form id="search-form" action="{{ url('/search') }}" method="post">
    <div class="row book-box">
        @if(isset($form))
            @php
                $airport_id     = $form['search']['airport'];
				$drop_off_date  = $form['search']['drop-off-date'];
				$drop_off_time  = $form['search']['drop-off-time'];
				$return_at_date = $form['search']['return-at-date'];
				$return_at_time = $form['search']['return-at-time'];
            @endphp
        @else
            @php
                $airport_id     = "";
				$drop_off_date  = "";
				$drop_off_time  = "";
				$return_at_date = "";
				$return_at_time = "";
            @endphp
        @endif
        <div class="col-xl-3 input1">
            <div class="home-label"><i><img src="{{ asset('/img/plane-mini.png') }}"></i> Airport <br/></div>
            <select class="form-control-sm air-width" id="airport-list" name="search[airport]">
                <option value="" readonly>-- Airports --</option>
                @if(isset($airports))
                    @foreach($airports as $airport)
                        @if(empty($airport_id))
                        <option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
                        @else
                        <option value="{{ $airport->id }}" {{ $airport_id == $airport->id ? "selected" : "" }}>{{ $airport->airport_name }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>

        <div class="col-xl-2 input2">
            <div class="home-label"> <i><img src="{{ asset('/img/calendar.png') }}"></i> Drop off <br/></div>
            <input type='date' name="search[drop-off-date]" id="drop-off-date" class="form-control-sm date-width" value="" />
        </div>
        <div class="col-xl-1 input3">
            <div class="home-label"><br></div>
            <input type="time" id="drop-off-time" name="search[drop-off-time]" class="form-control-sm time-width" value="">
            {{-- <select class="form-control-sm time-width" id="drop-off-time" name="search[drop-off-time]">
                @if(isset($drop_off_time_interval))
                {!! $drop_off_time_interval !!}
                @endif
            </select> --}}
        </div>

        <div class="col-xl-2 input4">
            <div class="home-label"><i><img src="{{ asset('img/calendar.png') }}"></i> Return at<br/></div>
            <input type='date' name="search[return-at-date]" id="return-at-date" class="form-control-sm date-width" value="" />
        </div>
        <div class="col-xl-1 input5">
           <div class="home-label"><br></div>
           <input type="time" id="return-at-time" name="search[return-at-time]" class="form-control-sm time-width" value="">
            {{-- <select class="form-control-sm time-width" id="return-at-time" name="search[return-at-time]">
                @if(isset($return_at_time_interval))
                {!! $return_at_time_interval !!}
                @endif
            </select> --}}
        </div>

        <div class="col-xl-3 input6">
            <button type="button" id="search" class="btn btn-primary btn-sm"><i><img src="{{ asset('/img/search.png') }}"/></i> Search Car Park</button>
        </div>
    </div>
    {{ csrf_field() }}
</form>
