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