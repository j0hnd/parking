	<thead>
	<tr>
		<th>Booking ID</th>
		<th>Order</th>
		<th class="text-center">Booking Date</th>
		<th class="text-center">Drop of Date</th>
		<th class="text-center">Return Date</th>
		<th class="text-center">Customer</th>
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
				$order_title = $booking->products[0]->airport[0]->airport_name.' - '.$booking->products[0]->carpark->name.' - '.$booking->products[0]->prices[0]->categories->category_name.' [No. of days: '.$booking->products[0]->prices[0]->no_of_days.']';
			@endphp

			<tr id="booking-{{ $booking->id }}" class="tr-shadow">
				<td>{{ $booking->booking_id }}</td>
				<td>{{ $order_title }}</td>
				<td class="text-center">{{ $booking->created_at->format('d/m/Y') }}</td>
				<td class="text-center">{{ $booking->drop_off_at->format('d/m/Y') }}</td>
				<td class="text-center">{{ $booking->return_at->format('d/m/Y') }}</td>
				<td class="text-center">
					<a href="javascript:void(0)" id="customer-details" class="customer-details" data-id="{{ $booking->customer_id }}">{{ ucwords($booking->customers->first_name) }} {{ ucwords($booking->customers->last_name) }}</a>
				</td>
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
			<tr id="customer-details-{{ $booking->customer_id }}-wrapper" class="customer-details-wrapper d-none" style="background-color: #b9ca4a">
				<td colspan="8" style="background-color: #b9ca4a">
					<table class="table table-data2" style="background-color: #b9ca4a">
						<tr style="background-color: #b9ca4a">
							<td>Customer Name: {{ ucwords($booking->customers->first_name) }} {{ ucwords($booking->customers->last_name) }}</td>
						</tr>
						<tr style="background-color: #b9ca4a">
							<td>Mobile No: {{ empty($booking->customers->mobile_no) ? "N/A" : $booking->customers->mobile_no }}</td>
							<td>Email: {{ empty($booking->customers->email) ? "N/A" : $booking->customers->email }}</td>
						</tr>
					</table>
				</td>
			</tr>
		@endforeach

		<tr id="summary" class="bg-aqua tr-shadow">
			<td colspan="7"></td>
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
