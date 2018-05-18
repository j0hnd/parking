@if(count($results))
    @foreach($results as $result)
    <div class="col-md-3">
        <div class="card-border">
            <div class="card-in">
                @if($result['services'])
                    @foreach($result['services'] as $service)
                        <div class="tooltip-icon">
                            <span class="card-icon"><i class="fa {{ trim($service['icon']) }}"></i></span>
                            <span class="tooltip-text">{{ $service['name'] }}</span>
                        </div>
                    @endforeach
                @endif
                <hr>
                <p class="card-title">{{ $result['carpark_name'] }}</p>
                <p class="card-sub">{{ $result['category'] }}</p>

                @if(is_null($result['image']))
                <img src="{{ asset('/img/booking/ace.png') }}" class="card-img">
                @else
                <img src="{{ asset($result['image']) }}" class="card-img">
                @endif

                <p class="price">£{{ $result['price'] }}</p>
                <a href="{{ url('/payment') }}" class="book-now" data-id="{{ $result['product_id'] }}" data-price="{{ $result['price'] }}">BOOK NOW</a><br/>
                <img src="{{ asset('/img/star-like.png') }}" class="star"><br/>
            </div>
            <a href="popup{{ $result['product_id'] }}" class="more"><i><img src="{{ asset('/img/booking/info.png') }}"></i> MORE INFO</a>
            <div id="popup{{ $result['product_id'] }}" class="overlay">
                <div class="popup">
                    <h1>Lorem ipsum dolor sit amet</h1><br/>
                    <a class="close3" href="#">&times;</a>
                    <div class="pop1-content">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.le VHS.
                    </div>
                </div>
            </div>
            <a class="plus collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $result['product_id'] }}" aria-expanded="false" aria-controls="collapseOne">
            </a>
            <div id="collapse{{ $result['product_id'] }}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                <p class="collapsable-title">Lorem ipsum dolor sit amet</p>
                <p class="collapsable-text">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.le VHS.</p>
            </div>
        </div>
    </div>
    @endforeach
@else
    <div class="col-md-12 bg-danger">
        <p class="text-center padding-10" style="color: #fff"><strong>No results found on the given criteria.</strong></p>
    </div>
@endif