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
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <h4>{{ $result['category'] }}</h4>

                                    @if(is_null($result['image']))
                                    <img src="{{ asset('/img/default.png') }}" class="img-fluid">
                                    @else
                                    <img src="{{ asset($result['image']) }}" class="img-fluid">
                                    @endif

                                </div>
                                <div class="col-lg-5">
                                    <div class="pop1-content">
                                        {{ $result['carpark_name'] }} - {{ $result['category'] }}
                                    </div>
                                </div>
                                <div class="col-lg-3 price-book">
                                    <p class="price">£{{ $price }}</p>
                                    <a href="javascript:void(0);" class="book-now toggle-book-now" data-id="{{ $i }}">BOOK NOW</a>
                                </div>
                            </div>
                        </div>
                    <a class="close3" href="#">&times;</a>
                    <br/><br/>
                   
                    <div  id="details-tab" class="detail-tab">
                        <h4 class="tab-title">Overview</h4>
                        <fieldset class="tab-content">
                            <h2 class="overview-title-first">Essentials</h2>
                            <ul class="tab-ul">
                                <li>Opening times: 24 Hours / 7 Days</li>
                                <li>Estimated journey time to airport: 10 minutes</li>
                                <li>Bus frequency: On Demand</li>
                                <li>Distance from airport: 10KM</li>
                                <li>Your keys will stay with the car park whilst you are away.</li>
                            </ul>
                            <h2 class="overview-title">Overview</h2>
                            <p class="tab-con">{!! html_entity_decode($result['description']) !!}</p>
                            <h2 class="overview-title">Why Book This Parking Space?</h2>
                            <ul class="tab-ul">
                                <li>Airport parking near BNE airport meeting all your expectations</li>
                                <li>Airport parking near BNE airport meeting all your expectations</li>
                                <li>Drivers fully uniformed and fully trained - high level of service</li>
                                <li>Full range of car servicing & repairs offered on arrival</li>
                            </ul>
                            <h2 class="overview-title">Disabled Info</h2>
                            <strong class="sub-title">Wheelchair Guests</strong>
                            <p class="tab-con">The car park buses don't have the ability to transfer wheelchair customers to/from the airport terminals.
                            Assuming you are travelling with at least one adult the wheelchair person should be dropped at the terminal first and the car then driven to the car park.</p>
                            <h2 class="overview-title">Additional Info</h2>
                            <strong class="sub-title">Travelling with children</strong>
                            <p class="tab-con">All of our drivers are trained to fit baby capsules for 0-3 year olds and we have plenty of baby capsules on site. We also carry booster seats for 4-7 year olds in all buses. Young families are always welcome.</p>
                            <p class="tab-con">Car detailing services available to book on arrival.</p>
                            <p class="tab-con">Please take a copy of your confirmation details with you on your day of travel.</p>
                        </fieldset>

                        <h4 class="tab-title">On Arrival</h4>
                        <fieldset class="tab-content">
                            <h2 class="overview-title-first">On Arrival</h2>
                            <p class="tab-con">{!! html_entity_decode($result['on_arrival']) !!}</p>
                        </fieldset>

                        <h4 class="tab-title">On Return</h4>
                        <fieldset class="tab-content">
                            <h2 class="overview-title-first">On Return</h2>
                            <p class="tab-con">{!! html_entity_decode($result['on_return']) !!}</p>
                        </fieldset>

                        <h4 class="tab-title">Directions</h4>
                        <fieldset class="tab-content">
                            <h2 class="overview-title-first">Sat Nav Info</h2>
                            <p class="tab-con">Lorem ipsum dolor sit amet<br/>
                                Lorem ipsum dolor sit amet<br/>
                                Lorem ipsum dolor sit amet
                            </p>
                            <h2 class="overview-title">Direction</h2>
                            <strong class="sub-title">Lorem ipsum dolor sit amet</strong>
                            <p class="tab-con">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.</p>

                            <strong class="sub-title">Lorem ipsum dolor sit amet</strong>
                            <p class="tab-con">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua.</p>
                        </fieldset>

                        <h4 class="tab-title">Map</h4>
                        <fieldset class="tab-content">
                            <h2 class="overview-title-first">Map</h2>
                        </fieldset>

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