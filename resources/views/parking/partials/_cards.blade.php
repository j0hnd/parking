@if(isset($results))
    @foreach($results as $i => $result)
    <div class="col-md-5 col-lg-4 col-xl-3">
        <form id="product-{{ $i }}" action="{{ url('/payment') }}" method="post">
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

                    @php
                        $price = number_format($result['price'], 2);
						$price = str_replace('.00', '', $price);
                    @endphp

                    <p class="price">£{{ $price }}</p>
                    <a href="javascript:void(0);" class="book-now toggle-book-now" data-id="{{ $i }}">BOOK NOW</a><br/>
                    <img src="{{ asset('/img/star-like.png') }}" class="star"><br/>

                    <input type="hidden" name="products" value="{{ $i }}:{{ $result['product_id'] }}:{{ $result['airport_id'] }}:{{ $result['price_id'] }}:{{ $result['price'] }}">
                    <input type="hidden" name="drop_off" value="{{ $result['drop_off'] }}">
                    <input type="hidden" name="return_at" value="{{ $result['return_at'] }}">
                </div>
                <a href="#popup{{ $i }}" class="more"><i><img src="{{ asset('/img/booking/info.png') }}"></i> MORE INFO</a>
                <br/>
                <div id="popup{{ $i }}" class="overlay">
                    <div class="popup">
                        <h1>Lorem ipsum dolor sit amet</h1><br/>
                        <a class="close3" href="#">&times;</a>
                        <div class="pop1-content">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.le VHS.
                        </div>
                    </div>
                </div>
                <a class="plus collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $i }}" aria-expanded="false" aria-controls="collapseOne">
                </a>
                <div id="collapse{{ $i }}" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                    <p class="collapsable-title">Lorem ipsum dolor sit amet</p>
                    <p class="collapsable-text">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.le VHS.</p>
                </div>
            </div>

            {{ csrf_field() }}
        </form>
    </div>
    @endforeach
@else
    <div class="col-md-12 bg-danger">
        <p class="text-center padding-10" style="color: #fff"><strong>No results found on the given criteria.</strong></p>
    </div>
@endif