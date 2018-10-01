<table>
	<thead>
	<tr>
		<th>Order Number</th>
		<th>Customer Name</th>
		<th>Airport</th>
		<th>Carpark Product Value</th>
		<th>Travel Agent</th>
		<th>Commission</th>
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
					$affiliate_name = $booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->company->company_name;
				} elseif(!empty($booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->first_name) and
						 !empty($booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->last_name)) {

					 $affiliate_name = $booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->first_name." ". $booking->affiliate_bookings[0]->affiliates[0]->travel_agent->members->last_name;
				} else {
					$affiliate_name = "N/A";
				}

				if (isset($booking->affiliate_bookings[0])) {
					$affiliate_percent = round($booking->affiliate_bookings[0]->affiliates[0]->percent_travel_agent / 100, 2);
					$commission = round($revenue_share * $affiliate_percent, 2);
					$total_commission += $commission;
				}
			@endphp

			<tr>
				<td>{{ $booking->booking_id }}</td>
				<td>{{ $booking->customers->first_name }} {{ $booking->customers->last_name }}</td>
				<td>{{ $booking->products[0]->airport[0]->airport_name }}</td>
				<td>£{{ $booking->price_value }}</td>
				<td>{{ $affiliate_name }}</td>
				<td>£{{ $commission }}</td>
			</tr>
		@endforeach
		<tr>
			<td>Total</td>
			<td>£{{ $total_commission }}</td>
		</tr>
	@else
		<tr>
			<td>No data found</td>
		</tr>
	@endif
	</tbody>
</table>