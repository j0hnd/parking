@extends('parking-app')

@section('css')
<link href="{{ asset('/css/terms.css') }}" rel="stylesheet">
@stop

@section('main-content')
 <div id="mobileNav" class="overlay-nav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div class="overlay-content">
        <a href="#">Contact Us</a>
        <a href="#">Login</a>
        <a href="#">Live Chat</a>
        <a href="#">Airport Parking</a>
      </div>
    </div>
    <nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
        <a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo.png') }}" class="navbar-brand"></a>
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

        <div class="container outer-con">
        	<div class="row">
        		<div class="col-md-12">
        			<h1 class="term-title">TERMS & CONDITIONS</h1>
        			<div class="container inner-con2">
        				<div class="row">
        					<div class="col-md-12">
        						<p class="term-head">Terms and Conditions for Airport Parking</p>
        						<hr>
        						<p class="term-content"> This is a legal document which contains contractual provisions (the “Terms and Conditions”). The customer’s Statutory Rights are not affected. These terms and conditions of booking are governed by English Law and are subject to the exclusive jurisdiction of the English courts. If any of these terms or part of any term are found to be invalid illegal or unenforceable then such term(s) shall be deemed modified to the minimum extent necessary to make it/them valid, legal and enforceable. If such modification is not possible the relevant provision or part-provision shall be deemed deleted. Any such modification to or deletion of a term or part term shall not affect the validity and enforceability of the rest of these terms.</p>
        					</div>
        				</div>
        			</div>
        			<br/>
        			<div class="container">
        				<div class="row">
        					<div class="col-md-8 inner-con">
        						
        						<p class="term-t">Definitions</p>
        						<hr/>
        					<ul class="list">
        						<li class="term-li">The “company” refers to My Travel Compared (a company registered in England with number 0000000).
        						</li>
								<li class="term-li">The “customer” refers to the person or persons using or proposing to use the services of the company.
								</li>
								<li class="term-li">The “service provider” refers to the operator of the featured car parks for which the company acts as a booking agent.
								</li>
								<li class="term-li">The “booking” refers to the specific service(s) purchased by the customer
								<li class="term-li">The “date of departure” refers to the date of the outward flight.
								</li>
								<li style="text-align: left;" class="term-li">“Onsite products” refers to those products specifically referred to as onsite products throughout the company’s website www.mytravelcompared.com/
								</li>
							</ul>
							<p class="term-t">The Company’s Liability</p>
        						<hr/>
        					<ul class="list">
        						<li class="term-li">These Terms and Conditions apply only to bookings made directly through this website. Bookings made via a third party website(s) are strictly subject to the terms and conditions set out on that website(s).
        						</li>
        						<li class="term-li">
								The company acts only as a booking agent for the service provider for the featured car parks. It does not itself provide the services. The customer will be contracting with the service provider and will be subject to the service provider’s terms and conditions. Full details of these terms and conditions are available from the service provider.
								</li>
        						<li class="term-li">
								As a booking agent for the service provider the company is liable to the customer only for losses directly arising from any negligence of the company in processing a booking. Any claims by the customer in respect of the delivery of the car parking services must be made against the service provider and subject to its terms and conditions.
								</li>
							</ul>
							<p class="term-t">Bookings</p>
        						<hr/>
        					<ul class="list">
							<li class="term-li">Bookings via the company’s website are deemed to have been made final once a booking reference number has been issued. All Terms and Conditions are deemed to have been accepted when a booking reference number has been issued.</li>

							<li class="term-li">Telephone bookings are deemed to have been made final when confirmed by the company’s telephone representative. All terms and conditions are deemed to have been accepted once confirmation of the booking has been issued.</li>

							<li class="term-li">All services are subject to availability.</li>

							<li class="term-li">The company reserves the right not to accept or fulfil a booking. A booking is not a guaranteed place and the company may cancel a booking if the service provider advises that it is unable to fulfil a booking. In these circumstances a refund will be given but the company accepts no liability for any consequential loss or losses arising.</li>

							<li class="term-li">It is the responsibility of the customer to ensure that a valid contact number and email address is provided at the time of making a booking.</li>

							<li class="term-li">It is the responsibility of the customer to ensure he/she reads the confirmation email before travelling.</li>

							<li class="term-li">The company will not accept liability for any costs incurred or consequential loss arising due to the failure of the customer to provide a valid contact number and email address or failing to read the confirmation email before travelling.</li>

							<li class="term-li">It is advisable for all customers to print the confirmation email and to take it when travelling to the chosen airport.</li>

							<li class="term-li">The company may use information supplied by the customer at the time of booking for the following purposes: (a) to fulfil the booking; (b) to processing and obtaining payment; (c) for analysis and profiling the customer’s car parking preferences (e.g. market, customer and product analysis) to enable review, development and improvement to the products and services offered; (d) to enable the company to provide the customer and other customers with relevant information through the company’s marketing programme. The company may keep the customer informed of its products and services using any of the following methods: e-mail, post, telephone, SMS. If the customer wishes to opt-out of these marketing activities please advise the company accordingly.</li>

							<li class="term-li">Car Parks which include a Price Guarantee or Money Back offer can only be applied to like for like products found on an alternative website within 24 hours of making a booking. Prices achieved by use of a discount code are excluded. All claims must be made in writing to our customer service team along with supporting documentation showing when and where the lower price was found. Upon confirmation a full refund will then be granted to the payment card with which the booking was originally made.</li>
							</ul>
							<p class="term-t">Payment</p>
        						<hr/>
        					<ul class="list">
        					<li class="term-li">Payment for a booking made by telephone or on the company’s website can only be made using MasterCard, Visa, American Express, Diners Club or Switch. Cheques are not accepted.</li>
							<li class="term-li">If payment by card is declined the company and the service provider reserve the right not to fulfil the booking.</li>
							<li class="term-li">All prices are quoted in the currency of the currently selected country and include VAT where applicable.</li>
							<li class="term-li">When a booking is made using a non-UK credit card the card issuer will debit the customer’s account in the local overseas currency and at the exchange rate applicable on the date of processing. A conversion charge may be applicable.</li>
        					</ul>
        					</div>
        					<div class="col-md-4 side-banner">
        						<div class="container banner-con">
        							<div class="row">
        								<div class="col-md-12">
        									<h1 class="banner-percent">90%</h1>
        									<hr>
        									<p class="cwu">of customer would use our booking service again</p>
        									<div class="read-review-con">
        									<a href="#" class="read-review" >Read our reviews from<br/> the last week</a>
        									</div>
        								</div>
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        </div>

    
@stop

@section('js')
<script src="{{ asset('/js/navigation.js') }}" type="text/javascript"></script>
@stop