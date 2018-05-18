@extends('parking-app')

@section('css')
	<link href="{{ asset('/css/payment.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/jquery.steps.css') }}" rel="stylesheet">

	{{-- Bootstrap datepicker --}}
	{{--<link href="{{ asset('/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css"/>--}}
@stop

@section('main-content')
	<main>
		<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
			<a href="index.html"> <img src="img/logo.png" class="navbar-brand"></a>
			<div class="mx-auto d-sm-flex d-block flex-sm-nowrap">

				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse text-center" id="navbarsExample11">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="contact-us.html">Contact Us</a>
						</li>
						<li>
							<div class="vl"></div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Membership</a>
						</li>
						<li>
							<div class="vl"></div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Live Chat</a>

						</li>
						<li>
							<div class="vl"></div>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Airport Parking</a>
						</li>
					</ul>

				</div>

			</div>

		</nav>
		<br/><br/><br/><br/><br/>
		<nav class="navbar-expand-lg navbar-light bg-light navbar-2">
			<ul class="navbar-nav ul-pos">
				<li class="nav-item active-2">
					<a class="nav-link link-2" href="#">Airport</a>
				</li>
				<li class="nav-item not-active">
					<a class="nav-link link-2" href="#">Meet & Greet</a>
				</li>
				<li class="nav-item not-active">
					<a class="nav-link link-2" href="#">On Airport</a>
				</li>
				<li class="nav-item not-active">
					<a class="nav-link link-2" href="#">Off Airport</a>
				</li>
			</ul>
		</nav>
		<div class="navbar-2-mobile">
			<ul>
				<li class="active-2-mobile">
					<a href="#">Airport</a>
				</li>
				<li class="not-active-2-mobile">
					<a href="#">Meet & Greet</a>
				</li>
				<li class="not-active-2-mobile">
					<a href="#">On Airport</a>
				</li>
				<li class="not-active-2-mobile">
					<a href="#">Off Airport</a>
				</li>
			</ul>
		</div>

		<div class="container full-wizard">
			<div class="row">
				<div class="col-md-8">
					<a href="airport-search.html" class="edit-search"><i class="fas fa-angle-left"></i> EDIT YOUR SEARCH</a>
				</div>
				<div class="col-md-4" id="top">
					<p>Lorem ipsum dolor sit amet, consectetur.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<a href="airport-search.html"><p class="tab-1">&nbsp;&nbsp;Find Parking<br/><img src="img/booking/airplane1.png" class="air1"></p></a>
					<form id="payment_wizard">
						<h3>Payment<img src="img/booking/airplane2.png" class="air2"></h3>
						<section>
							<div class="container wizard-content">
								<div class="row">
									<div class="col-md-12">
										<i><img src="img/booking/person.png"> Details</i>
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label>
											First Name:
										</label>
										<input type="text" name="firstname" class="form-control">
									</div>
									<div class="col-md-6">
										<label>
											Last Name:
										</label>
										<input type="text" name="lastname" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label>
											Email Address:
										</label>
										<input type="text" name="email" class="form-control">

									</div>
									<div class="col-md-6">
										<label>
											Confirm Email Address:
										</label>
										<input type="text" name="confirm_email" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label>
											Area Code:
										</label>
										<select class="form-control">
											<option>
												(+44) United Kingdom
											</option>
										</select>
									</div>
									<div class="col-md-6">
										<label>
											Phone Number:
										</label>
										<input type="text" name="phone" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-6">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="sms" checked>
											SMS Confirmation + £0.49
										</label>
									</div>
									<div class="col-md-6">
										<label class="form-check-label">
											<input type="checkbox" class="form-check-input" name="cancellation">
											Cancellation Waiver + £1.99
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
										<label>
											Vehicle Registration:
										</label>
										<input type="text" name="registration" class="form-control">

									</div>
									<div class="col-md-6">
										<label>
											Vehicle Model:
										</label>
										<input type="text" name="model" class="form-control">
									</div>
								</div>
								<br/>
								<div class="row">
									<div class="col-md-12">
										<label>
											Vehicle Color:
										</label>
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
												<i><img src="img/booking/wallet.png"> Payment Details</i>
											</div>
											<div class="col-md-6 credit">
												<i><img src="img/booking/credit-card.png" class="credit-card"></i>
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-12">

												<label>
													Name On Card:
												</label>
												<input type="text" name="card_name" class="form-control">

											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-12">

												<label>
													Card Number:
												</label>
												<input type="text" name="card_number" class="form-control">

											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-6">
												<label>
													Expiration Date:
												</label>
												<input type="text" name="expiration" class="form-control">

											</div>
											<div class="col-md-6">
												<label>
													CV Code:
												</label>
												<input type="text" name="cv_code" class="form-control">
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-md-12">

												<label>
													Coupon Code:
												</label>
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
												<i><img src="img/booking/wallet.png"> Payment Details</i>
											</div>
											<div class="col-md-6 credit">
												<i><img src="img/booking/paypal.png" class="paypal"></i>
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
						<h3>Details<img src="img/booking/airplane3.png" class="air3"></h3>
						<section>
							<p>Try 2</p>
						</section>
						<h3>Takeoff!<img src="img/booking/airport4.png" class="air4"></h3>
						<section>
							<p>Try 3</p>
						</section>
					</form>
				</div>

				<div class="col-md-4">
					<div id="sidebar">
						<div class="container receipt">
							<div class="row align-rec-img">
								<div class="col-md-12">
									<img src="img/booking/parking.png" class="receipt-img">
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
									<p class="receipt-align">01/12/18</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<p>To Date</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align">01/12/18</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p class="receipt-name">AIRPORT NAME</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align">€ 50.00</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p class="receipt-name">BOOKING FEE</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align">€ 1.99</p>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-6">
									<p>TOTAL PRICE</p>
								</div>
								<div class="col-md-6">
									<p class="receipt-align total">€ 50.00</p>
								</div>
							</div>
						</div>
						<br/>
						<div class="container">
							<div class="row">
								<div class="col-md-6">
									<img src="img/booking/app-store.png" class="app-full">
								</div>
								<div class="col-md-6">
									<img src="img/booking/google-play.png" class="app-full">
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						<p class="foot-col1">Lorem ipsum dolor sit amet,<br/>
							consectetur adipisicing elit,<br/>
							sed do eiusmodtempor incididunt<br/>
							labore et dolore magna aliqua.</p>
					</div>
					<div class="col-md-4">
						<p class="foot-col2">AIRPORT</p>
						<p class="foot-col2-sub">PARKING SYSTEM</p>
					</div>
					<div class="col-md-4 col3-align">
						<p class="foot-col3">
							CONTACT US!
						</p>
						<div class="info">
							<i style="margin-right: 15px;"><img src="img/tele.png"></i> (028)231 5344<br/><br/>
							<i style="margin-right: 15px;"><img src="img/email.png"></i> loremipsum@lorem.com<br/><br/>
							<i style="margin-right: 18px;"><img src="img/gps.png"></i> Lorem ipsum dolor sit amet,<br/>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;consectetur adipisicing elit.
						</div>
					</div>
				</div>
			</div>
		</footer>
	</main>
@stop

@section('js')
	{{--<script src="{{ asset('/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>--}}
	<script src="{{ asset('/js/affix.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/js/jquery.steps.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/js/payment.js') }}" type="text/javascript"></script>
@stop