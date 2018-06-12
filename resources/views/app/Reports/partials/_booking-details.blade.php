@php
	$total_booking_fee = 0;
	$total_sms = 0;
	$total_cancellation = 0;
	$total_share = 0;
	$total_revenue = 0;
@endphp

@if(count($bookings))
	@foreach($bookings as $booking)
		@php
			$total_booking_fee += $booking->booking_fees;
			$total_sms += $booking->sms_confirmation_fee;
			$total_cancellation += $booking->cancellation_waiver;
			$total_revenue += $booking->revenue_value;
		@endphp

		<tr id="booking-{{ $booking->id }}">
			<td><a href="{{ url('/admin/booking/'.$booking->id.'/edit') }}">{{ $booking->booking_id }}</a></td>
			<td>{{ $booking->order_title }}</td>
			<td class="text-right">£{{ number_format($booking->booking_fees, 2) }}</td>
			<td class="text-right">{{ is_null($booking->sms_confirmation_fee) ? 0  : "£".number_format($booking->sms_confirmation_fee, 2)}}</td>
			<td class="text-right">{{ is_null($booking->cancellation_waiver) ? 0  : "£".number_format($booking->cancellation_waiver, 2)}}</td>
			<td class="text-center">{{ $booking->products[0]->revenue_share }}%</td>
			<td class="text-right">£{{ $booking->revenue_value + $booking->booking_fees + (is_null($booking->sms_confirmation_fee) ? 0 : $booking->sms_confirmation_fee) + (is_null($booking->cancellation_waiver) ? 0 : $booking->cancellation_waiver) }}</td>
		</tr>
	@endforeach
	<tr id="summary" class="danger">
		<td colspan="2"></td>
		<td class="text-right"><strong>£{{ number_format($total_booking_fee, 2) }}</strong></td>
		<td class="text-right"><strong>£{{ number_format($total_sms, 2) }}</strong></td>
		<td class="text-right"><strong>£{{ number_format($total_cancellation, 2) }}</strong></td>
		<td class="text-center"></td>
		<td class="text-right"><strong>£{{ number_format($total_revenue, 2) }}</strong></td>
	</tr>
@else
	<tr>
		<td colspan="7" class="text-center"><strong>No data found</strong></td>
	</tr>
@endif