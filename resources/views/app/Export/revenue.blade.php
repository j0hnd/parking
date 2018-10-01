<table>
	<thead>
	<tr>
		<th>Order Number</th>
		<th>Vendor's Name</th>
		<th>Airport</th>
		<th>Parking Type</th>
		<th>Carpark Amount<br/><small>(less commission)</small></th>
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

			<tr>
				<td>{{ $booking->booking_id }}</td>
				<td>{{ $booking->products[0]->carpark->name }}</td>
				<td>{{ $booking->products[0]->airport[0]->airport_name }}</td>
				<td>{{ $parking_type }}</td>
				<td>£{{ $carpark_amount }}</td>
			</tr>
		@endforeach

		<tr>
			<td colspan="4">Total</td>
			<td>£{{ number_format($total_carpark_amount, 2) }}</td>
		</tr>
	@else
		<tr>
			<td colspan="5"><strong>No data found</strong></td>
		</tr>
	@endif
	</tbody>
</table>