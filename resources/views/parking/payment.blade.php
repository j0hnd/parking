@extends('parking-app')
@section('title')
  Payment |
@stop
@section('css')
  <link href="{{ asset('/bower_components/form.validation/dist/css/formValidation.css') }}" rel="stylesheet">
  <link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet">
  <link href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/payment.css') }}" rel="stylesheet">
  <link href="{{ asset('/css/jquery.steps.css') }}" rel="stylesheet">
  <style type="text/css">
  .help-block {
    color: #a94442 !important;
  }
  .datepicker {
    padding: 8px !important;
    z-index: 2002 !important;
  }
  /* Absolute Center Spinner */
  .loading {
    position: fixed;
    z-index: 99999;
    height: 2em;
    width: 2em;
    overflow: show;
    margin: auto;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
  }

  /* Transparent Overlay */
  .loading:before {
    content: '';
    display: block;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.3);
  }

  /* :not(:required) hides these rules from IE9 and below */
  .loading:not(:required) {
    /* hide "loading..." text */
    /*   font: 0/0 a; */
    /*   color: transparent; */
    text-shadow: none;
    background-color: transparent;
    border: 0
  }

  .loading:not(:required):after {
    content: '';
    display: block;
    font-size: 10px;
    width: 1em;
    height: 1em;
    margin-top: -0.5em;
    -webkit-animation: spinner 1500ms infinite linear;
    -moz-animation: spinner 1500ms infinite linear;
    -ms-animation: spinner 1500ms infinite linear;
    -o-animation: spinner 1500ms infinite linear;
    animation: spinner 1500ms infinite linear;
    border-radius: 0.5em;
    -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
  }

  /* Animation */
  @-webkit-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @-moz-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @-o-keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  @keyframes spinner {
    0% {
      -webkit-transform: rotate(0deg);
      -moz-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
      -o-transform: rotate(0deg);
      transform: rotate(0deg);
    }
    100% {
      -webkit-transform: rotate(360deg);
      -moz-transform: rotate(360deg);
      -ms-transform: rotate(360deg);
      -o-transform: rotate(360deg);
      transform: rotate(360deg);
    }
  }
  </style>
@stop

@section('main-content')
  <main>

    @include('parking.templates.nav-mobile')

    <nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
      <a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo.png') }}" class="navbar-brand"></a>
      @include('parking.templates.nav2')
      <span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
    </nav>

    <br/><br/><br/><br/><br/>

    <nav class="navbar-expand-lg navbar-light bg-light navbar-2">

    </nav>

    <div class="navbar-2-mobile">

    </div>

    <div class="container full-wizard">
      <div class="row">
        <div class="col-md-8">
          <a href="{{ url('/') }}" class="edit-search"><i class="fas fa-angle-left"></i> EDIT YOUR SEARCH</a>
        </div>
        <div class="col-md-4" id="top">
          <p></p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <a href="{{ url('/') }}"><p class="tab-1">&nbsp;&nbsp;Find Parking<br/><img src="{{ asset('/img/booking/airplane1.png') }}" class="air1"></p></a>
          <form id="payment_wizard" action="{{ url('/paypal') }}" method="post">
            <h3>Payment<img src="{{ asset('img/booking/airplane2.png') }}" class="air2"></h3>
            <section data-step="0">
              <div class="container wizard-content">
                <div class="row">
                  <div class="col-md-12">
                    <i><img src="{{ asset('/img/booking/person.png') }}"> Details</i>
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-md-6">
                    <label>First Name:</label>
                    <input type="text" id="firstname-src" name="firstname" class="form-control" data-validation="required" value="{{ is_null($details) ? "" : $details['firstname'] }}">
                  </div>
                  <div class="col-md-6">
                    <label>Last Name:</label>
                    <input type="text" id="lastname-src" name="lastname" class="form-control" data-validation="required" value="{{ is_null($details) ? "" : $details['lastname'] }}">
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-md-6">
                    <label>Email Address:</label>
                    <input type="text" id="email-src" name="email" class="form-control" value="{{ is_null($details) ? "" : $details['email'] }}">

                  </div>
                  <div class="col-md-6">
                    <label>Confirm Email Address:</label>
                    <input type="text" name="confirm_email" class="form-control" value="{{ is_null($details) ? "" : $details['email'] }}">
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-md-6">
                    <label>Area Code:</label>
                    <select class="form-control" name="country_code">
                      <option value="GB">(+44) United Kingdom</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Phone Number:</label>
                    <input type="text" id="phone-src" name="phone" class="form-control"  value="{{ is_null($details) ? "" : $details['phoneno'] }}">
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-md-6">
                    @if(is_null($details['sms']))
                      @php
                      $sms_checked = '';
                      @endphp
                    @else
                      @if($details['sms'] == 0)
                        @php
                        $sms_checked = '';
                        @endphp
                      @else
                        @php
                        $sms_checked = 'checked';
                        @endphp
                      @endif
                    @endif
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" id="sms-fee" name="sms-fee" value="{{ $sms_confirmation_fee->amount }}" {{ $sms_checked }}>
                      SMS Confirmation + £{{ $sms_confirmation_fee->amount }}
                    </label>
                  </div>
                  <div class="col-md-6">
                    @if(is_null($details['cancellation']))
                      @php
                      $cancel_checked = '';
                      @endphp
                    @else
                      @if($details['cancellation'] == 0)
                        @php
                        $cancel_checked = '';
                        @endphp
                      @else
                        @php
                        $cancel_checked = 'checked';
                        @endphp
                      @endif
                    @endif
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" id="cancellation-fee" name="cancellation-fee" value="{{ $cancellation_waiver->amount }}" {{ $cancel_checked }}>
                      Cancellation Waiver + £{{ $cancellation_waiver->amount }}
                    </label>
                  </div>
                </div>
                <br/>
                <hr>
                <br/>
                <div class="row">
                  <div class="col-md-12">
                    <i><img src="{{ asset('/img/booking/wheel.png') }}"> Vehicle Details</i>
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-md-6">
                    <label>Vehicle Registration:</label>
                    <input type="text" id="car-registration-no-src" name="car_registration_no" class="form-control" value="{{ is_null($details) ? "" : $details['car_registration_no'] }}">
                  </div>
                  <div class="col-md-6">
                    <label>Vehicle Color:</label>
                    <input type="text" id="vehicle-color-src" name="vehicle_color" class="form-control" value="{{ is_null($details) ? "" : $details['vehicle_color'] }}">
                  </div>
                  <div class="col-md-6">
                    <label>Vehicle Make:</label>
                    <select class="form-control" id="vehicle-make-src" name="vehicle_make">
                      <option value="" readonly>-- Vehicle Make --</option>
                      @if(count($vehicle_make))
                        @foreach($vehicle_make as $i => $vm)
                          @if($vm['value'] == $details['vehicle_make'])
                            <option value="{{ $vm['title'] }}" data-index="{{ $i }}" selected>{{ $vm['title'] }}</option>
                          @else
                            <option value="{{ $vm['title'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
                          @endif
                        @endforeach
                        <option value="-1" data-index="-1">Other Vehicle Make</option>
                      @endif
                    </select>
                    <input type="text" class="form-control d-none" id="other-vehicle-make-src" placeholder="Other Vehicle Make" name="other_vehicle_make" autocomplete="off" style="margin-top:5px;">
                  </div>
                  <div class="col-md-6">
                    <label>Vehicle Model:</label>
                    @if(isset($details))
                      <select class="form-control d-none" name="vehicle_model" id="vehicle-model-src">
                        <option value="" readonly> -- Vehicle Model -- </option>
                      </select>
                      <input type="text" class="form-control" id="other-vehicle-model-src" placeholder="Vehicle Model" name="other_vehicle_model" autocomplete="off" value="{{ $details['vehicle_model'] }}">
                    @else
                      <select class="form-control" name="vehicle_model" id="vehicle-model-src">
                        <option value="" readonly> -- Vehicle Model -- </option>
                      </select>
                      <input type="text" class="form-control d-none" id="other-vehicle-model-src" placeholder="Other Vehicle Model" name="other_vehicle_model" autocomplete="off" style="margin-top:5px;">
                    @endif

                    {{--<input type="text" id="vehicle-model-src" name="vehicle_model" class="form-control" value="{{ is_null($details) ? "" : $details['vehicle_model'] }}">--}}
                  </div>
                </div>
                <br/>
                <hr/>
                <br/>
                <div class="row">
                  <div class="col-md-12">
                    <i><img src="{{ asset('/img/booking/coupon.png') }}" style="width: 26px; height: 26px;"> Coupons</i>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-12">
                    <label>Coupon Code:</label>
                    <input type="text" id="coupon-src" name="coupon_src" class="form-control" value="{{ isset($details['coupon']) ? $details['coupon'] : "" }}">
                    <span id="coupon-error" class="d-none" style="color:red"><small>Coupon not valid!</small></span>
                  </div>
                </div>
                <br/>
              </div>
              <br/>

              <div id="payment_choice">
                @if(is_null($details))
                  <h4>Credit / Debit Card</h4>
                  <fieldset>
                    <div class="container" id="stripe-container">
                      <div class="row">
                        <div class="col-md-6">
                          <i><img src="{{ asset('/img/booking/wallet.png') }}"> Payment Details</i>
                        </div>
                        <div class="col-md-6 credit">
                          <i><img src="{{ asset('/img/booking/credit-card.png') }}" class="credit-card"></i>
                        </div>
                      </div>
                      <br/>
                      <div class="row">
                        <div class="col-md-12">
                          <label>Name On Card:</label>
                          <input type="text" id="card-name-src" name="card_name" class="form-control">

                        </div>
                      </div>
                      <br/>
                      <div class="row">
                        <div class="col-md-12">
                          <label>Card Number:</label>
                          <input type="text" id="card-number-src" name="card_number" class="form-control">
                        </div>
                      </div>
                      <br/>
                      <div class="row">
                        <div class="col-md-4">
                          <label>Expiration Date:</label>
                          <select name="expiration-month" id="expiration-month-src" class="form-control">
                            <option value="" readonly="">-- Month --</option>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label>Expiration Date:</label>
                          <select name="expiration_year" id="expiration-year-src" class="form-control">
                            <option value="" readonly="">-- Year --</option>
                            <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            @for($i = 1; $i <= 10; $i++)
                              <option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
                            @endfor
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label>Security Number (CVV):</label>
                          <input type="text" id="cv-code-src" name="cv_code" class="form-control">
                        </div>
                      </div>
                      <br>
                      <br>
                      <a href="javascript:void(0)" id="toggle-stripe" class="btn btn-primary btn-block" style="padding:14px;">Confirm Booking</a>
                      <p class="text-center" style="margin-top: 7px;"><small>Once submitted we will send you a confirmation email</small>
                        <br><small>By clicking <strong>Confirm Booking</strong> you agree to our <a href="{{ url('/terms') }}" target="_blank">terms and conditions</a> </small></p>
                      </div>
                      <div id="stripe-payment-loader" class="row d-none">
                        <div class="col-md-12 text-center">
                          <img src="{{ asset('/img/loader.gif') }}">
                          <p>Please wait, processing payment...</p>
                        </div>
                      </div>
                      <div id="stripe-message-wrapper" class="row d-none">
                        <div class="col-md-12 text-center">
                          <p class="text-center" style="margin-top: 20px;"></p>
                        </div>
                      </div>
                    </fieldset>

                    <h4>PayPal</h4>
                    <fieldset>
                      <div class="container" id="paypal-container">
                        <div class="row">
                          <div class="col-md-6">
                            <i><img src="{{ asset('/img/booking/wallet.png') }}"> Payment Details</i>
                          </div>
                          <div class="col-md-6 credit">
                            <i><img src="{{ asset('/img/booking/paypal.png') }}" class="paypal"></i>
                          </div>
                        </div>
                        <div class="row paypal-align">
                          <div class="col-md-12">
                            <p class="paypal-details">A pop-up window will appear for PayPal login <br/>when you proceed with PayPal </p>
                            <br/><br/>
                            <a href="javascript:void(0)" id="toggle-paypal" class="paypal-button"><i class="fab fa-paypal"></i> PayPal</a>
                          </div>
                        </div>
                        <p class="text-center" style="margin-top: 17px;"><small>Once submitted we will send you a confirmation email</small>
                          <br><small>By clicking <strong>Paypal</strong> button you agree to our <a href="{{ url('/terms') }}" target="_blank">terms and conditions</a> </small></p>
                        </div>
                      </fieldset>
                    @else
                      <div class="row">
                        @if($cancel == 1)
                          <div class="col-md-12 text-center padding-top30">
                            <h4>Oops! Something went wrong while processing your payment or you opt to cancel.<br/>Thus, you will not be able to continue booking this carpark.</h4>
                          </div>
                        @else
                          <div class="col-md-12 text-center padding-top30">
                            <h4>Your payment has been confirmed!</h4><br>Please proceed with the next step in completing this booking.<br>Thank you.
                          </div>
                        @endif
                      </div>
                    @endif

                    @php
                    $price_value = str_replace(',', '', $price_value);
                    $total = $price_value + $booking_fee->amount;
                    $total = number_format($total, 2);
                    $total = str_replace('.00', '', $total);
                    @endphp
                  </div>
                  <br/>
                </section>

                <h3>Details<img src="{{ asset('/img/booking/airplane3.png') }}" class="air3"></h3>
                <section data-step="1">
                  @if(!is_null($form))
                    @php
                    list($drop_off_date, $drop_off_time) = explode(' ', $form['drop_off']);
                    list($return_at_date, $return_at_time) = explode(' ', $form['return_at']);
                    @endphp
                  @else
                    @php
                    $drop_off_date = '';
                    $drop_off_time = '';
                    $return_at_date = '';
                    $return_at_time = '';
                    @endphp
                  @endif

                  <div class="container wizard-content">
                    <div class="row">
                      <div class="col-md-12">
                        <i><img src="{{ asset('/img/booking/person.png') }}"> Booking Details</i>
                      </div>
                    </div>
                    <br/>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Flight No. (Departure):</label>
                        <input type="text" id="departure-src" name="flight_no_going" class="form-control" data-validation="required">
                      </div>
                      <div class="col-md-6">
                        <label>Flight No. (Arrival):</label>
                        <input type="text" id="arrival-src" name="flight_no_return" class="form-control" data-validation="required">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-md-6">
                        <label>Terminal (Deperture):</label>
                        <select class="form-control" id="departure-terminal-src" name="departure_terminal" style="width:100% !important">
                          <option value="" readonly> -- Terminal --</option>
                          {!! $terminals !!}
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label>Terminal (Arrival):</label>
                        <select class="form-control" id="arrival-terminal-src" name="arrival_terminal" style="width:100% !important">
                          <option value="" readonly> -- Terminal --</option>
                          {!! $terminals !!}
                        </select>
                      </div>
                    </div>
                    <br/>

                    <br/>
                    <div class="row">
                      <div class="col-md-6">
                        <label>No. of passengers in vehicle</label>
                        <input type="text" id="no-of-passengers-in-vehicle-src" name="no_of_passengers_in_vehicle" class="form-control" data-validation="required">
                      </div>
                      <div class="col-md-6">
                        <div class="col-md-12">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="with-oversize-baggage" name="with_oversize_baggage">
                            Travelling with sports or oversize baggage
                          </label>
                        </div>
                        <div class="col-md-12">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" id="with-children-pwd" name="with_children_pwd">
                            Travelling with children or disabled passengers
                          </label>
                        </div>
                      </div>
                    </div>
                    <br/>
                  </div>
                </section>

                <h3>Takeoff!<img src="{{ asset('/img/booking/airport4.png') }}" class="air4"></h3>
                <section data-step="2">
                  <div class="container wizard-content">
                    <div class="row">
                      <div id="finish-wrapper" class="col-md-12 d-none" style="font-size: 12px;">
                        <p>Hi <span id="customer-name"></span>,</p>
                        <p>Here are your bookings details, please review and confirm if all details are correct:</p>
                        <p><h6>Booking Details</h6></p>
                        <p><strong>Booking Reference</strong>: <span id="booking-id-wrapper"></span></p>
                        <p><strong>Airport</strong>: <span id="airport"></span></p>
                        <p><strong>Service</strong>: <span id="service"></span></p>
                        <hr>
                        <p><h6>Flight Details</h6></p>
                        <p><strong>Flight No. (Departure)</strong>: <span id="flight-no-departure"></span>, <strong>Terminal</strong>: <span id=flight-departure-terminal></span> </p>
                        <p><strong>Flight No. (Arrival)</strong>: <span id="flight-no-arrival"></span>, <strong>Terminal</strong>: <span id="flight-arrival-terminal"></span> </p>
                        <p><strong>Drop Off</strong>: <span id="drop-off"></span></p>
                        <p><strong>Return At</strong>: <span id="return-at"></span></p>
                        <hr>
                        <p><h6>Vendor Details</h6></p>
                        <p><strong>Carpark Name</strong>: <span id="vendor-name"></span></p>
                        <p><strong>Contact Person: </strong>: <span id="vendor-poc-name"></span></p>
                        <p><strong>Phone No</strong>: <span id="vendor-phone-no"></span></p>
                        <p><strong>Email</strong>: <span id="vendor-email"></span></p>
                        <hr>
                        <p><h6>Vehicle Details</h6></p>
                        <p><strong>Registration No</strong>: <span id="vd-registration-no"></span></p>
                        <p><strong>Make</strong>: <span id="vd-vehicle-make"></span></p>
                        <p><strong>Model</strong>: <span id="vd-vehicle-model"></span></p>
                        <p><strong>Color</strong>: <span id="vd-vehicle-color"></span></p>
                      </div>
                      <div id="confirmation-wrapper" class="col-md-12 text-center" style="font-size: 13px;">
                        <p>Click the <strong>Finish</strong> button if all your details are correct.</p>
                      </div>
                    </div>
                  </div>
                </section>
              </form>

              <form id="order-form" action="{{ url('/paypal') }}" method="post">
                <input type="hidden" id="product" name="product" value="{{ $airport->airport_name }} - {{ $product->carpark->name }} - {{ $price->categories->category_name }} [£{{ $price->price_value }}]">
                <input type="hidden" id="ids" name="ids"  value="{{ $product->id }}:{{ $price->id }}:{{ $product->airport[0]->id }}">
                <input type="hidden" id="total-amount" name="total"  value="{{ $total }}">
                <input type="hidden" id="firstname" name="firstname" />
                <input type="hidden" id="lastname" name="lastname" />
                <input type="hidden" id="email" name="email" />
                <input type="hidden" id="phoneno" name="phoneno" />
                <input type="hidden" id="sms" name="sms">
                <input type="hidden" id="sms-confirmation" name="sms-confirmation">
                <input type="hidden" id="cancellation" name="cancellation">
                <input type="hidden" id="booking-fee" name="booking_fee" value="{{ $booking_fee->amount }}">
                <input type="hidden" id="car-registration-no" name="car_registration_no">
                <input type="hidden" id="vehicle-make" name="vehicle_make">
                <input type="hidden" id="vehicle-model" name="vehicle_model">
                <input type="hidden" id="other-vehicle-make" name="other_vehicle_make">
                <input type="hidden" id="other-vehicle-model" name="other_vehicle_model">
                <input type="hidden" id="vehicle-color" name="vehicle_color">
                <input type="hidden" id="card-name" name="card_name">
                <input type="hidden" id="card-number" name="card_number">
                <input type="hidden" id="expiration-month" name="expiration-month">
                <input type="hidden" id="expiration-year" name="expiration-year">
                <input type="hidden" id="cv-code" name="cv_code">
                {{ csrf_field() }}
              </form>

              <form id="booking-details-form" data-url="{{ url('/booking/details/'. $booking_id .'/update') }}">
                {{-- <input type="hidden" id="drop_off_at" name="drop_off_at">
                <input type="hidden" id="return_at" name="return_at"> --}}
                <input type="hidden" id="flight_no_going" name="flight_no_going">
                <input type="hidden" id="flight_no_return" name="flight_no_return">
                <input type="hidden" id="no_of_passengers_in_vehicle" name="no_of_passengers_in_vehicle">
                <input type="hidden" id="with_oversize_baggage" name="with_oversize_baggage">
                <input type="hidden" id="with_children_pwd" name="with_children_pwd">
                <input type="hidden" id="departure_terminal" name="departure_terminal">
                <input type="hidden" id="arrival_terminal" name="arrival_terminal">
                <input type="hidden" id="bid" name="bid" value="{{ $booking_id }}">
                {{ csrf_field() }}
              </form>
            </div>

            <div class="col-md-4">
              <div id="sidebar">
                <div class="container receipt">
                  <div class="row align-rec-img">
                    <div class="col-md-12">
                      @if(empty($product->image))
                        <img src="{{ asset('/img/default.png') }}" class="receipt-img">
                      @else
                        <img src="{{ asset($product->image) }}" class="receipt-img">
                      @endif
                      <br/>
                      <hr>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <a class="collapsed side-more" data-toggle="collapse" data-parent="#accordion" href="#collapse" aria-expanded="true" aria-controls="collapseOne">more info...</a>
                      <div id="collapse" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                        {{--<p class="collapsable-title">Lorem ipsum dolor sit amet</p>--}}
                        <p class="collapsable-text">{!! html_entity_decode($product->short_description) !!}</p>
                      </div>
                    </div>
                  </div>
                  <br/>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p>Drop Off Date</p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">{{ date('d/m/Y', strtotime($drop_off_date)) }}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p>Drop Off Time</p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">{{ $drop_off_time }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p>Return Date</p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">{{ date('d/m/Y', strtotime($return_at_date)) }}</p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p>Return Time</p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">{{ $return_at_time }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p class="receipt-name">{{ $airport->airport_name }}</p>
                      <p class="h6">{{ $price->categories->category_name }}</p>
                    </div>
                    <div class="col-6 col-md-6">
                      @php
                      $price_value = number_format($price_value, 2);
                      $price_value = str_replace('.00', '', $price_value);
                      @endphp
                      <p class="receipt-align">£{{ $price_value }}</p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p class="receipt-name">BOOKING FEE</p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">£{{ $booking_fee->amount }}</p>
                    </div>
                  </div>
                  <div id="sms-confirmation-container" class="row d-none">
                    <div class="col-6 col-md-6">
                      <p class="receipt-name"><small>SMS Confirmation</small></p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">£<span id="sms-fee-wrapper">0</span></p>
                    </div>
                  </div>
                  <div id="cancellation-waiver-container" class="row d-none">
                    <div class="col-6 col-md-6">
                      <p class="receipt-name"><small>Cancellation Waiver</small></p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">£<span id="cancellation-waiver-wrapper">0</span></p>
                    </div>
                  </div>
                  <div id="coupon-container" class="row d-none">
                    <div class="col-6 col-md-6">
                      <p class="receipt-name"><small>Coupon Dis.<span id="coupon-discount" style="color:red; margin-left:5px"></span></small></p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align">£<span id="coupon-wrapper">0</span></p>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-6 col-md-6">
                      <p>TOTAL PRICE</p>
                    </div>
                    <div class="col-6 col-md-6">
                      <p class="receipt-align total" id="total" data-value="{{ $total }}" data-raw-value="{{ $price_value }}">£{{ $total }}</p>
                    </div>
                  </div>
                </div>
                <br/>
                <div class="container">
                  <div class="row">
                    <div class="col-md-6 text-center app-store">
                      <img src="{{ asset('/img/booking/app-store.png') }}" class="app-full">
                    </div>
                    <div class="col-md-6 text-center google-play">
                      <img src="{{ asset('/img/booking/google-play.png') }}" class="app-full">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="loading d-none"></div>
      </main>
    @stop

    @section('js')
      <script src="{{ asset('/bower_components/form.validation/dist/js/formValidation.js') }}" type="text/javascript"></script>
      <script src="{{ asset('/bower_components/form.validation/dist/js/framework/bootstrap.js') }}" type="text/javascript"></script>
      <script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}" type="text/javascript"></script>
      <script src="{{ asset('/bower_components/select2/dist/js/select2.min.js') }}"></script>
      <script src="{{ asset('/js/affix.js') }}" type="text/javascript"></script>
      <script src="{{ asset('/js/jquery.steps.min.js') }}" type="text/javascript"></script>
      <script src="{{ asset('/js/payment.js') }}" type="text/javascript"></script>
      <script type="text/javascript">
      $(document).ready(function () {
        var vehicle_model = "{{ $details['vehicle_model'] }}";
        var payment_confirm = "{{ $payment_confirm }}";
        var cancel = "{{ $cancel }}";

        $('.datepicker').datepicker();
        $('#vehicle-make-src').select2();
        $('#departure-terminal-src').select2();
        $('#arrival-terminal-src').select2();

        if (vehicle_model == "") {
          $('#vehicle-model-src').removeClass('d-none');
          $('#other-vehicle-model-src').addClass('d-none');
          $('#vehicle-model-src').select2();
        } else {
          $('#vehicle-model-src').addClass('d-none');
          $('#other-vehicle-model-src').removeClass('d-none');
        }

        if ((payment_confirm == 0 && cancel == 0) || (payment_confirm == 1 && cancel == 1)) {
          setTimeout(function () {
            $("a[href='#next']").parent().addClass("disabled").attr("aria-disabled", "true");
            $('div.actions ul li:nth-child(1) a').attr('href', 'javascript:void(0)');
            $('div.actions ul li:nth-child(2) a').attr('href', 'javascript:void(0)');
          }, 300);
        }

        $(document).on('click', '#toggle-stripe', function (e) {
          if ($('#firstname-src').val() == '' && $('#lastname-src').val() == '' && $('#email-src').val() == '' &&
              $('#card-name-src').val() == '' && $('#card-number-src').val() == '' && $('#expiration-month-src').val() == '' &&
              $('#expiration-year-src').val() == '' && $('#cv-code-src').val() == '') {

              alert('Firstname, lastname, email and credit card details should not be empty');

          } else {
              $('#firstname').val($('#firstname-src').val());
              $('#lastname').val($('#lastname-src').val());
              $('#email').val($('#email-src').val());
              $('#phoneno').val($('#phone-src').val());
              $('#car-registration-no').val($('#car-registration-no-src').val());
              $('#vehicle-color').val($('#vehicle-color-src').val());
              $('#vehicle-make').val($('#vehicle-make-src').val());
              $('#vehicle-model').val($('#vehicle-model-src').val());
              $('#other-vehicle-make').val($('#other-vehicle-make-src').val());
              $('#other-vehicle-model').val($('#other-vehicle-model-src').val());

              if ($('#vehicle-make').val() == -1) {
                  $('#vehicle-make').val($('#other-vehicle-make-src').val());
              }

              if ($('#vehicle-model').val().indexOf('Other') != -1) {
                  $('#vehicle-model').val($('#other-vehicle-model-src').val());
              }

              $('#coupon').val($('#coupon-src').val());
              $('#card-name').val($('#card-name-src').val());
              $('#card-number').val($('#card-number-src').val());
              $('#expiration-month').val($('#expiration-month-src').val());
              $('#expiration-year').val($('#expiration-year-src').val());
              $('#cv-code').val($('#cv-code-src').val())

              if ($('#sms-fee').is(':checked')) {
                  $('#sms').val($('#sms-fee').val());
              } else {
                  $('#sms').val(0);
              }

              if ($('#cancellation-fee').is(':checked')) {
                  $('#cancellation').val($('#cancellation-fee').val());
              } else {
                  $('#cancellation').val(0);
              }

              $.ajax({
                  url: '/stripe/payment',
                  type: 'post',
                  data: $('#order-form').serialize(),
                  dataType: 'json',
                  cache: false,
                  beforeSend: function () {
                      $('#payment_choice').find('#stripe-payment-loader').removeClass('d-none');
                      $('#payment_choice').find('#stripe-container').addClass('d-none');
                      $('.loading').removeClass('d-none');
                  },
                  success: function (response) {
                      $('#payment_choice').find('#stripe-payment-loader').addClass('d-none');
                      $('#payment_choice').find('#stripe-container').removeClass('d-none');
                      $('.loading').addClass('d-none');

                      if (response.success) {
                          $('#payment_choice').find('#stripe-container').addClass('d-none');
                          $('#payment_choice').find('#stripe-message-wrapper').removeClass('d-none');
                          $('#payment_choice').find('#stripe-message-wrapper p').html("<h4>Your payment has been confirmed!</h4><br>Please proceed with the next step in completing this booking.<br>Thank you.");

                          $('#bid').val(response.data);

                          $("#toggle-stripe").addClass("disabled").attr("aria-disabled", "true");
                          $("a[href='#next']").parent().removeClass("disabled").attr("aria-disabled", "false");
                          $('div.actions ul li:nth-child(1)').attr('href', '#previous');
                          $('div.actions ul li:nth-child(2)').attr('href', '#next');
                      } else {
                          $('#payment_choice').find('#stripe-container').addClass('d-none');
                          $('#payment_choice').find('#stripe-message-wrapper').removeClass('d-none');
                          $('#payment_choice').find('#stripe-message-wrapper p').html("<h4>Oops! Something went wrong in processing your payment.</h4><br>" + response.message);

                          setTimeout(function () {
                              $('#payment_choice').find('#stripe-container').removeClass('d-none');
                              $('#payment_choice').find('#stripe-message-wrapper').addClass('d-none');
                          }, 3000);
                      }
                  }
              });
          }
        });
      });
    </script>
  @stop
