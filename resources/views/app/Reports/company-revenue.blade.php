@extends('admin_template')

@section('styles')
<style type="text/css">
	#summary td {
		font-size: 18px;
	}
</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'company_revenues', 'generate_url' => url('/admin/reports/vendor/revenues')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				@php
					$total = 0;
				@endphp
				<table class="table table-striped">
					<thead>
					<tr>
						<th class="col-md-2">Order Number</th>
						<th class="col-md-3">Vendor's Name</th>
						<th class="col-md-2">Airport</th>
						<th class="col-md-1">Parking Type</th>
						<th class="col-md-1 text-right">Carpark Amount<br/><small>(less commission)</small></th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@php
							$total_carpark_amount = 0;
						@endphp
						@foreach($bookings as $booking)
							@php
								list($airport_name, $parking_type) = explode('-', $booking->order_title);
								$carpark_amount = $booking->price_value - $booking->price_value * round(($booking->products[0]->revenue_share/100), 2);
								$total_carpark_amount += $carpark_amount;
							@endphp

						<tr id="booking-{{ $booking->id }}">
							<td>{{ $booking->booking_id }}</td>
							<td>{{ $booking->products[0]->carpark->name }}</td>
							<td>{{ $booking->products[0]->airport[0]->airport_name }}</td>
							<td>{{ $parking_type }}</td>
							<td class="text-right">£{{ $carpark_amount }}</td>
						</tr>
						@endforeach

						<tr id="summary" class="bg-aqua">
							<td colspan="4" class="text-right">Total</td>
							<td class="text-right"><strong>£{{ number_format($total_carpark_amount, 2) }}</strong></td>
						</tr>
					@else
						<tr>
							<td colspan="5" class="text-center"><strong>No data found</strong></td>
						</tr>
					@endif
					</tbody>

					@if(count($bookings))
						<tfoot>
						<tr>
							<td colspan="5" class="text-right">{{ $bookings->links() }}</td>
						</tr>
						</tfoot>
					@endif
				</table>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ url('js/reports.js') }}" type="text/javascript"></script>
	<script type="text/javascript">
		$(function () {
		    var selected_date = '{{ $selected_date }}';
		    setTimeout(function () {
                if (selected_date) {
                    $("#reportrange span").html(selected_date);
                }
            }, 300);
		});
	</script>
@stop