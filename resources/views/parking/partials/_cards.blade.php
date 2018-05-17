@if(count($results))
    @foreach($results as $result)
    <div class="col-md-3">
        <div class="card-border">
            <div class="card-in">
                <img src="{{ asset('/img/booking/block.png') }}" class="card-icon">
                <img src="{{ asset('/img/booking/cctv.png') }}" class="card-icon">
                <img src="{{ asset('/img/booking/secure.png') }}" class="card-icon">
                <img src="{{ asset('/img/booking/bulb.png') }}" class="card-icon">
                <img src="{{ asset('/img/booking/family.png') }}" class="card-icon">
                <img src="{{ asset('/img/booking/bike.png') }}" class="card-icon">
                <hr>
                <p class="card-title">ACE PARKING</p>
                <p class="card-sub">{{ $result['category'] }}</p>
                <img src="{{ asset('/img/booking/ace.png') }}" class="card-img">
                <p class="price">£{{ $result['price'] }}</p>
                <a href="#" class="book-now">BOOK NOW</a><br/>
                <img src="{{ asset('/img/star-like.png') }}" class="star"><br/>
            </div>
            <a href="#" class="more"><i><img src="{{ asset('/img/booking/info.png') }}"></i> MORE INFO</a>
        </div>
    </div>
    @endforeach
@else
    <div class="col-md-12 bg-danger">
        <p class="text-center padding-10" style="color: #fff"><strong>No results found on the given criteria.</strong></p>
    </div>
@endif