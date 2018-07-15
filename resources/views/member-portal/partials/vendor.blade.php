	<thead>
	<tr>
		<th>Booking ID</th>
		<th>Order</th>
		<th class="text-center">Booking Date</th>
		<th class="text-center">Drop of Date</th>
		<th class="text-center">Return Date</th>
		<th class="text-center">Completed</th>
		<th class="text-right">Total Cost</th>
	</tr>
	</thead>

	<tbody>
	@if($bookings)
		@php
			$total_cost = 0;
		@endphp

		@foreach($bookings as $booking)
			@php
				$cost = 0;
			@endphp

			<tr id="booking-{{ $booking->id }}" class="tr-shadow">
				<td>{{ $booking->booking_id }}</td>
				<td>{{ $booking->order_title }}</td>
				<td class="text-center">{{ $booking->created_at->format('d/m/Y') }}</td>
				<td class="text-center">{{ $booking->drop_off_at->format('d/m/Y') }}</td>
				<td class="text-center">{{ $booking->return_at->format('d/m/Y') }}</td>
				<td class="text-center">
					 @if(strtotime('now') > strtotime($booking->return_at))
					 <i class="fas fa-check-square" aria-hidden="true"></i>
					 @endif
				</td>
				<td class="text-right">
					@php
						$cost = ($booking->price_value + $booking->booking_fee + $booking->sms_confirmation_fee + $booking->cancellation_waiver) - $booking->revenue_value;
						$total_cost += $cost;
					@endphp

					£{{ number_format($cost, 2) }}
				</td>
			</tr>
		@endforeach

		<tr id="summary" class="bg-aqua tr-shadow">
			<td colspan="6"></td>
			<td class="text-right"><strong>£{{ number_format($total_cost, 2) }}</strong></td>
		</tr>
	@else
		<tr class="tr-shadow">
			<td colspan="8" class="text-center"><strong>No data found</strong></td>
		</tr>
	@endif
	</tbody>

	@if(count($bookings))
		<tfoot>
		<tr class="tr-shadow">
			<td colspan="8" class="text-right">{{ $bookings->links() }}</td>
		</tr>
		</tfoot>
	@endif
</table>
