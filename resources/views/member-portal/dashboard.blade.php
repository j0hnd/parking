@extends('parking-app')

@section('css')
	<link href="{{ asset('/css/parking-search.css') }}" rel="stylesheet">
	<style type="text/css">
		footer {
			bottom: 0;
			position: absolute;
			width: 100%;
			height: 250px;
		}
	</style>
@stop

@section('main-content')
	<nav class="navbar navbar-expand-sm navbar-light bg-light" data-toggle="affix">
		<a href="{{ url('/') }}"> <img src="{{ asset('/img/header-logo-light.png') }}" class="navbar-brand"></a>
		@include('parking.templates.member-nav')
		<span class="nav-icon" onclick="openNav()"><i class="fas fa-bars"></i></span>
	</nav>

	<br/><br/><br/><br/><br/>

	<nav class="navbar-expand-lg navbar-light bg-light navbar-2">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h4 style="color:white;">Welcome {{ $user->members->first_name }}!</h4>
			</div>
		</div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3 class="padding-20">Dashboard</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Booking ID</th>
							<th>Order Title</th>
							<th>Booking Date</th>
							<th class="text-right">Amount</th>
						</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@foreach($bookings as $booking)
						<tr>
							<td>{{ $booking->booking_id }}</td>
							<td>
								{{ $booking->order_title }}<br>
								<small>
									<span style="display: block;">Drop Off: {{ $booking->drop_off_at->format('d/m/Y') }}</span>
									<span style="display: block;">Return At: {{ $booking->return_at->format('d/m/Y') }}</span>
								</small>
							</td>
							<td>{{ $booking->created_at->format('d/m/Y') }}</td>
							<td class="text-right">
								@php
									$sms_fee = is_null($booking->sms_confirmation_fee) ? 0 : $booking->sms_confirmation_fee;
									$cancellation_waiver = is_null($booking->cancellation_waiver) ? 0 : $booking->cancellation_waiver;
									$amount = $booking->price_value + $booking->booking_fee + $sms_fee + $cancellation_waiver;
								@endphp
								£{{ number_format($amount, 2) }}
							</td>
						</tr>
						@endforeach
					@else
						<tr>
							<td colspan="4">No bookings found</td>
						</tr>
					@endif
					</tbody>

					@if(count($bookings))
					<tfoot>
						<tr>
							<td colspan="4">
								{{ $bookings->links() }}
							</td>
						</tr>
					</tfoot>
					@endif
				</table>
			</div>
		</div>
	</div>

	<input type="hidden" id="token" value="{{ csrf_token() }}">
@stop

@section('js')
@stop