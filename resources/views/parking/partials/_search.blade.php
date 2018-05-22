<form action="{{ url('/search') }}" method="post">
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
        <div class="col-md-3 input1">
            <div class="home-label"><i><img src="{{ asset('/img/plane-mini.png') }}"></i> Airport <br/></div>
            <select class="form-control-sm" id="airport" name="search[airport]" style="width:100%">
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
        <div class="col-md-2 input2">
            <div class="home-label"> <i><img src="{{ asset('/img/calendar.png') }}"></i> Drop off <br/></div>
            <input type='text' name="search[drop-off-date]" class="form-control-sm datepicker" placeholder="mm/dd/yyyy" value="{{ empty($drop_off_date) ? date('m/d/Y') : $drop_off_date }}" />
        </div>
        <div class="col-md-1 input3">
            <div class="home-label"><br></div>
            <select class="form-control-sm" name="search[drop-off-time]">
                @if(isset($drop_off_time_interval))
                {!! $drop_off_time_interval !!}
                @endif
            </select>
        </div>
        <div class="col-md-2 input4">
            <div class="home-label"><i><img src="{{ asset('img/calendar.png') }}"></i> Return at<br/></div>
            <input type='text' name="search[return-at-date]" class="form-control-sm datepicker" placeholder="mm/dd/yyyy" value="{{ empty($return_at_date) ? date('m/d/Y') : $return_at_date }}" />
        </div>
        <div class="col-md-1 input5">
           <div class="home-label"><br></div>
            <select class="form-control-sm" name="search[return-at-time]">
                @if(isset($return_at_time_interval))
                {!! $return_at_time_interval !!}
                @endif
            </select>
        </div>
        <div class="col-md-3 input6">
            <button type="submit" class="btn btn-primary btn-sm"><i><img src="{{ asset('/img/search.png') }}"/></i> Search Car Park</button>
        </div>
    </div>
    {{ csrf_field() }}
</form>
