@extends('parking-app')

@section('css')
	<link href="{{ asset('/css/payment.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jquery.steps.css') }}" rel="stylesheet">
@stop

@section('main-content')
	<main>
		 <div id="mobileNav" class="overlay-nav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="#">Contact Us</a>
        <a href="#">Membership</a>
        <a href="#">Live Chat</a>
        <a href="#">Airport Parking</a>
      </div>
    </div>
		<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
			<a href="{{ url('/') }}"> <img src="img/header-logo.png" class="navbar-brand"></a>
			@include('parking.templates.nav2')
			 <span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
		</nav>

		<br/><br/><br/><br/><br/>

		<nav class="navbar-expand-lg navbar-light bg-light navbar-2">
			@include('parking.templates.nav3')
		</nav>

		<div class="navbar-2-mobile">
			@include('parking.templates.nav3-mobile')
		</div>

		<div class="container full-wizard">
			<div class="row">
				<div class="col-md-8">
					<a href="{{ url('/') }}" class="edit-search"><i class="fas fa-angle-left"></i> EDIT YOUR SEARCH</a>
				</div>
				<div class="col-md-4" id="top">
					<p>Lorem ipsum dolor sit amet, consectetur.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<a href="{{ url('/') }}"><p class="tab-1">&nbsp;&nbsp;Find Parking<br/><img src="{{ asset('/img/booking/airplane1.png') }}" class="air1"></p></a>
					<form id="payment_wizard" data-parsley-validate="">
						<h3>Payment<img src="{{ asset('img/booking/airplane2.png') }}" class="air2"></h3>
						<section>
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
										<input type="text" name="firstname" class="form-control" required="">
									</div>
									<div class="col-md-6">
										<label>Last Name:</label>
										<input type="text" name="lastname" class="form-control" required="">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label>Email Address:</label>
										<input type="text" name="email" class="form-control">

									</div>
									<div class="col-md-6">
										<label>Confirm Email Address:</label>
										<input type="text" name="confirm_email" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label>Area Code:</label>
										<select class="form-control">
											<option>(+44) United Kingdom</option>
										</select>
									</div>
									<div class="col-md-6">
										<label>Phone Number:</label>
										<input type="text" name="phone" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" id="sms-fee" name="sms" value="{{ $sms_confirmation_fee->amount }}" checked>
											SMS Confirmation + £{{ $sms_confirmation_fee->amount }}
										</label>
									</div>
									<div class="col-md-6">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" id="cancellation" name="cancellation" value="{{ $cancellation_waiver->amount }}">
											Cancellation Waiver + £{{ $cancellation_waiver->amount }}
										</label>
									</div>
								</div>
								<br/>
								<hr>
								<br/>
								<div class="row">
									<div class="col-md-12">
										<i><img src="img/booking/wheel.png"> Vehicle Details</i>
									</div>

								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label>Vehicle Registration:</label>
										<input type="text" name="registration" class="form-control">

									</div>
									<div class="col-md-6">
										<label>Vehicle Model:</label>
										<input type="text" name="model" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-12">
										<label>Vehicle Color:</label>
										<input type="text" name="car-color" class="form-control">
									</div>
								</div>
							</div>
							<br/>
							<div id="payment_choice">
								<h4>Credit / Debit Card</h4>
								<fieldset>
									<div class="container">
										<div class="row">
											<div class="col-md-6">
												<i><img src="{{ asset('/img/booking/wallet.png') }}"> Payment Details</i>
											</div>
											<div class="col-md-6 credit">
												<i><img src="img/booking/credit-card.png" class="credit-card"></i>
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-12">
												<label>Name On Card:</label>
												<input type="text" name="card_name" class="form-control">

											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-12">
												<label>Card Number:</label>
												<input type="text" name="card_number" class="form-control">
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-6">
												<label>Expiration Date:</label>
												<input type="text" name="expiration" class="form-control">
											</div>
											<div class="col-md-6">
												<label>CV Code:</label>
												<input type="text" name="cv_code" class="form-control">
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-12">
												<label>Coupon Code:</label>
												<input type="text" name="coupon" class="form-control">
											</div>
										</div>
										<br/>
										<p>Lorem ipsum dolor</p>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
											tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
										</p>
									</div>
								</fieldset>
								<h4>PayPal</h4>
								<fieldset>
									<div class="container">
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
												<a href="#" class="paypal-button"><i class="fab fa-paypal"></i> PayPal</a>
											</div>
										</div>
									</div>
								</fieldset>
							</div>
							<br/>
						</section>

						<h3>Details<img src="{{ asset('/img/booking/airplane3.png') }}" class="air3"></h3>
						<section><p>Try 2</p></section>

						<h3>Takeoff!<img src="{{ asset('/img/booking/airport4.png') }}" class="air4"></h3>
						<section><p>Try 3</p></section>
					</form>
				</div>

				<div class="col-md-4">
					<div id="sidebar">
						<div class="container receipt">
							<div class="row align-rec-img">
								<div class="col-md-12">
									<img src="{{ asset('/img/booking/parking.png') }}" class="receipt-img">
									<br/>
									<hr>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<p>more info...</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p>From Date</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align">{{ $drop_off_date }} {{ $drop_off_time }}</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p>To Date</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align">{{ $return_at_date }} {{ $return_at_time }}</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p class="receipt-name">{{ $airport->airport_name }}</p>
									<p class="h6">{{ $price->categories->category_name }}</p>
								</div>
								<div class="col-md-6">
									@php
										$price_value = number_format($price_value, 2);
										$price_value = str_replace('.00', '', $price_value);
									@endphp
									<p class="receipt-align">£{{ $price_value }}</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p class="receipt-name">BOOKING FEE</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align">£{{ $booking_fee->amount }}</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p>TOTAL PRICE</p>
								</div>
								<div class="col-md-6">
									@php
										$price_value = str_replace(',', '', $price_value);
										$total = $price_value + $booking_fee->amount;
										$total = number_format($total, 2);
										$total = str_replace('.00', '', $total);
									@endphp
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
<script src="{{ asset('/js/affix.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/jquery.steps.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/payment.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(function () {
	// $('#payment_wizard').parsley().on('field:validated', function() {
	// 	var ok = $('.parsley-error').length === 0;
	// 	// $('.bs-callout-info').toggleClass('hidden', !ok);
	// 	// $('.bs-callout-warning').toggleClass('hidden', ok);
	// })
	// .on('form:submit', function() {
	// 	return false; // Don't submit form for this demo
	// });
});
</script>
@stop