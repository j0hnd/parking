@extends('admin_template')

@section('styles')
	<style type="text/css">
		#summary td {
			font-size: 18px;
		}

		.drop-off {
			color: #0000ee;
		}

		.return-at {
			color: #002a80;
		}
	</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'travel_agents', 'generate_url' => url('/admin/reports/travel/agents')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th class="text-center">Order Number</th>
						<th class="text-center">Customer Name</th>
						<th class="text-center">Airport</th>
						<th class="text-right">Carpark Product Value</th>
						<th class="text-center">Travel Agent</th>
						<th class="text-right">Commission</th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@php
							$total_commission = 0;
							$commission = 0;
						@endphp

						@foreach($bookings as $booking)
							@php
								$revenue_share = number_format($booking->price_value * ($booking->products[0]->revenue_share/100), 2);

								if (isset($booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->company->company_name)) {
									$affiliate_company_name = $booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->company->company_name;
								} else {
									$affiliate_company_name = "N/A";
								}

								if (isset($booking->affiliate_bookings[0])) {
									$affiliate_percent = round($booking->affiliate_bookings[0]->affiliates[0]->percent_travel_agent / 100, 2);
									$commission = round($revenue_share * $affiliate_percent, 2);
									$total_commission += $commission;
								}
							@endphp

							<tr id="booking-{{ $booking->id }}">
								<td class="text-center"><a href="{{ url('/admin/booking/'.$booking->id.'/edit') }}" target="_blank">{{ $booking->booking_id }}</a></td>
								<td class="text-center ">{{ $booking->customers->first_name }} {{ $booking->customers->last_name }}</td>
								<td class="text-center">{{ $booking->products[0]->airport[0]->airport_name }}</td>
								<td class="text-right">£{{ $booking->price_value }}</td>
								<td class="text-center">{{ $affiliate_company_name }}</td>
								<td class="text-right">£{{ $commission }}</td>
							</tr>
						@endforeach
						<tr id="summary" class="bg-aqua">
							<td colspan="5">Total</td>
							<td class="text-right"><strong>£{{ $total_commission }}</strong></td>
						</tr>
					@else
						<tr>
							<td colspan="6" class="text-center"><strong>No data found</strong></td>
						</tr>
					@endif
					</tbody>

					@if(count($bookings))
						<tfoot>
						<tr>
							<td colspan="6" class="text-right">{{ $bookings->links() }}</td>
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
