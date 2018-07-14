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
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" id="sms-fee" name="sms-fee" value="{{ $sms_confirmation_fee->amount }}" {{ isset($details['sms']) ? 'checked' : '' }}>
											SMS Confirmation + £{{ $sms_confirmation_fee->amount }}
										</label>
									</div>
									<div class="col-md-6">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" id="cancellation-fee" name="cancellation-fee" value="{{ $cancellation_waiver->amount }}" {{ isset($details['cancellation']) ? 'checked' : '' }}>
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
													<option value="{{ $vm['value'] }}" data-index="{{ $i }}" selected>{{ $vm['title'] }}</option>
													@else
													<option value="{{ $vm['value'] }}" data-index="{{ $i }}">{{ $vm['title'] }}</option>
													@endif
												@endforeach
											@endif
										</select>
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
										<input type="text" class="form-control d-none" id="other-vehicle-model-src" placeholder="Vehicle Model" name="other_vehicle_model" autocomplete="off">
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
											<div class="col-md-6">
												<label>Expiration Date:</label>
												<input type="text" id="expiration-src" name="expiration" class="form-control">
											</div>
											<div class="col-md-6">
												<label>CV Code:</label>
												<input type="text" id="cv-code-src" name="cv_code" class="form-control">
											</div>
										</div>
									</div>
									<div id="stripe-payment-loader" class="row d-none">
										<div class="col-md-12 text-center">
											<img src="{{ asset('/img/loader.gif') }}">
											<p>Please wait, connecting to payment gateway.</p>
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
									</div>
								</fieldset>
								@else
								<div class="row">
									@if($cancel == 1)
									<div class="col-md-12 text-center padding-top30">
										<h4>Your payment has been cancelled</h4>
									</div>
									@else
									<div class="col-md-12 text-center padding-top30">
										<h4>Thank you! Your payment is confirmed.</h4>
										<p>Please continue and complete the details of your booking.</p>
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
									<div class="col-md-4">
										<label>Drop Off Date:</label>
										<input type="text" id="drop-off-date-src" name="drop_off_date" class="form-control datepicker" value="{{ $drop_off_date }}" data-validation="required">
									</div>
									<div class="col-md-2">
										<label>Time:</label>
										<select class="form-control" id="drop-off-time-src" name="drop_off_time" data-validation="required">
											@if(isset($drop_off_time_interval))
												{!! $drop_off_time_interval !!}
											@endif
										</select>
									</div>

									<div class="col-md-4">
										<label>Return Date:</label>
										<input type="text" id="return-at-date-src" name="return_at_date" class="form-control datepicker" value="{{ $return_at_date }}" data-validation="required">
									</div>
									<div class="col-md-2">
										<label>Time:</label>
										<select class="form-control" id="return-at-time-src" name="return_at_time" data-validation="required">
											@if(isset($return_at_time_interval))
												{!! $return_at_time_interval !!}
											@endif
										</select>
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
									<div id="finish-wrapper" class="col-md-12 d-none" style="font-size: 22px;">
										<p>Hi <span id="customer-name"></span>,</p>
										<p>The Booking Reference No. is <span id="booking-id-wrapper"></span> for your <span id="order-title"></span> is on <span id="drop-off"></span> to <span id="return-at"></span></p>
										<p>You will also be receiving an email for the details of your booking.</p>
									</div>
									<div id="confirmation-wrapper" class="col-md-12 text-center" style="font-size: 22px;">
										<p>Click the <strong>Finish</strong> button if all your details are correct.</p>
									</div>
								</div>
							</div>
						</section>
					</form>

					<form id="order-form" action="{{ url('/paypal') }}" method="post">
						<input type="hidden" id="product" name="product" value="{{ $airport->airport_name }}-{{ $price->categories->category_name }}">
						<input type="hidden" id="ids" name="ids"  value="{{ $product->id }}:{{ $price->id }}">
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
						<input type="hidden" id="other-vehicle-model-src" name="other_vehicle_model">
						<input type="hidden" id="vehicle-color" name="vehicle_color">
						<input type="hidden" id="card-name" name="card_name">
						<input type="hidden" id="card-number" name="card_number">
						<input type="hidden" id="expiration" name="expiration">
						<input type="hidden" id="cv-code" name="cv_code">
						{{ csrf_field() }}
					</form>

					<form id="booking-details-form" data-url="{{ url('/booking/details/'. $booking_id .'/update') }}">
						<input type="hidden" id="drop_off_at" name="drop_off_at">
						<input type="hidden" id="return_at" name="return_at">
						<input type="hidden" id="flight_no_going" name="flight_no_going">
						<input type="hidden" id="flight_no_return" name="flight_no_return">
						<input type="hidden" id="no_of_passengers_in_vehicle" name="no_of_passengers_in_vehicle">
						<input type="hidden" id="with_oversize_baggage" name="with_oversize_baggage">
						<input type="hidden" id="with_children_pwd" name="with_children_pwd">
						<input type="hidden" id="bid" name="bid" value="{{ $booking_id }}">
						{{ csrf_field() }}
					</form>
				</div>

				<div class="col-md-4">
					<div id="sidebar">
						<div class="container receipt">
							<div class="row align-rec-img">
								<div class="col-md-12">
									@if(empty($carpark->image))
									<img src="{{ asset('/img/default.png') }}" class="receipt-img">
									@else
									<img src="{{ asset($carpark->image) }}" class="receipt-img">
									@endif
									<br/>
									<hr>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<a class="collapsed side-more" data-toggle="collapse" data-parent="#accordion" href="#collapse" aria-expanded="false" aria-controls="collapseOne">more info...</a>
									<div id="collapse" class="collapse" role="tabpanel" aria-labelledby="headingOne">
				                    <p class="collapsable-title">Lorem ipsum dolor sit amet</p>
				                    <p class="collapsable-text">Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.</p>
				                </div>
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-6 col-md-6">
									<p>From Date</p>
								</div>
								<div class="col-6 col-md-6">
									<p class="receipt-align">{{ $drop_off_date }}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-6 col-md-6">
									<p>To Date</p>
								</div>
								<div class="col-6 col-md-6">
									<p class="receipt-align">{{ $return_at_date }}</p>
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
									<p class="receipt-align total" id="total" data-value="{{ $total }}">£{{ $total }}</p>
								</div>
							</div>
						</div>
						<br/>
						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<img src="{{ asset('/img/booking/app-store.png') }}" class="app-full">
								</div>
								<div class="col-md-6">
									<img src="{{ asset('/img/booking/google-play.png') }}" class="app-full">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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
{{--<script src="https://js.stripe.com/v3/"></script>--}}
<script type="text/javascript">
	$(document).ready(function () {
	    var vehicle_model = "{{ $details['vehicle_model'] }}";

        $('.datepicker').datepicker();
        $('#vehicle-make-src').select2();

		if (vehicle_model == "") {
            $('#vehicle-model-src').removeClass('d-none');
            $('#other-vehicle-model-src').addClass('d-none');
            $('#vehicle-model-src').select2();
		} else {
            $('#vehicle-model-src').addClass('d-none');
            $('#other-vehicle-model-src').removeClass('d-none');
		}
    });
</script>
@stop
