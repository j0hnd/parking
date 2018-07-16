<thead>
	<tr>
		<th>Booking ID</th>
		<th>Order Title</th>
		<th>Booking Date</th>
		<th>Drop Off</th>
		<th>Return</th>
		<th class="text-right">Amount</th>
	</tr>
	</thead>

	<tbody>
	@if(count($bookings))
		@foreach($bookings as $booking)
			<tr class="tr-shadow">
				<td>{{ $booking->booking_id }}</td>
				<td>{{ $booking->order_title }}<br></td>
				<td>{{ $booking->created_at->format('d/m/Y') }}</td>
				<td>{{ $booking->drop_off_at->format('d/m/Y H:i') }}</td>
				<td>{{ $booking->return_at->format('d/m/Y H:i') }}</td>
				<td class="text-right">
					@php
						$sms_fee = is_null($booking->sms_confirmation_fee) ? 0 : $booking->sms_confirmation_fee;
						$cancellation_waiver = is_null($booking->cancellation_waiver) ? 0 : $booking->cancellation_waiver;
						$amount = $booking->price_value + $booking->booking_fee + $sms_fee + $cancellation_waiver;

						if (isset($booking->affiliate_bookings[0]->affiliates)) {
							$percent_travel_agent = $booking->affiliate_bookings[0]->affiliates[0]->percent_travel_agent;
							$amount = $amount * round(($percent_travel_agent/ 100), PHP_ROUND_HALF_UP);
						}
					@endphp

					£{{ number_format($amount, 2) }}
				</td>
			</tr>
		@endforeach
	@else
		<tr class="tr-shadow">
			<td colspan="6">No bookings found</td>
		</tr>
	@endif
	</tbody>

	@if(count($bookings))
		<tfoot>
		<tr class="tr-shadow">
			<td colspan="6">
				{{ $bookings->links() }}
			</td>
		</tr>
		</tfoot>
	@endif
