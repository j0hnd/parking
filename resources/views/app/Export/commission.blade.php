<html>
	<style type="text/css">
		th {
			font-weight: bold !important;
		}
	</style>

	<table>
		<thead>
			<tr>
				<th colspan="10" align="center"><h3><b>Commissions</b></h3></th>
			</tr>
			<tr>
				<th>Booking ID</th>
				<th>Commission (%)</th>
				<th>Vendor's Name</th>
				<th>Total Order Value</th>
				<th>Car Parking Product Value</th>
				<th>Revenue Share</th>
				<th>Booking Fee</th>
				<th>SMS Confirmation Fee</th>
				<th>Cancellation Waiver</th>
				<th>Affiliate Cost (%)</th>
			</tr>
		</thead>

		<tbody>
		@if(count($data))

			@php
				$total_order_value = 0;
				$total_price_value = 0;
				$total_revenue_share = 0;
				$total_booking_fee = 0;
				$total_sms_confirmation_fee = 0;
				$total_cancellation_waiver = 0;
				$total_affiliate_cost = 0;

				$affiliate_cost = 0;
				$order_value = 0;
				$revenue_share = 0;
				$sms_confirmation_fee = 0;
				$cancellation_waiver = 0;
				$affiliate_cost = 0;
			@endphp

			@foreach($data as $i => $d)

				@php
					$color = ($i % 2 == 0) ? "#f4f4f4" : "#ffffff";

					if (isset($d->affiliate_bookings[0])) {
						$affiliate_percent = round($d->affiliate_bookings[0]->affiliates[0]->percent_travel_agent / 100, 2);
						$affiliate_cost = round($d->products[0]->revenue_share * $affiliate_percent, 2);
					} else {
						$affiliate_cost = '0';
					}

					$order_value = $d->price_value + $d->booking_fees + $d->sms_confirmation_fee + $d->cancellation_wavier;
					$revenue_share = number_format($d->price_value * ($d->products[0]->revenue_share/100), 2);

					$sms_confirmation_fee = empty($d->sms_confirmation_fee) ? '0' : $d->sms_confirmation_fee;
					$cancellation_waiver = empty($d->cancellation_waiver) ? '0' : $d->cancellation_waiver;

					$total_order_value += $order_value;
					$total_price_value += $d->price_value;
					$total_revenue_share += $revenue_share;
					$total_booking_fee += $d->booking_fees;
					$total_sms_confirmation_fee += $sms_confirmation_fee;
					$total_cancellation_waiver += $cancellation_waiver;
					$total_affiliate_cost += $affiliate_cost;
				@endphp

				<tr style="background: {{ $color }}">
					<td>{{ $d->booking_id }}</td>
					<td>{{ $d->products[0]->carpark->name }}</td>
					<td align="center">{{ $d->products[0]->revenue_share }}%</td>
					<td align="right">£{{ $order_value }}</td>
					<td align="right">£{{ $d->price_value }}</td>
					<td align="right">£{{ $revenue_share }}</td>
					<td align="right">£{{ $d->booking_fees }}</td>
					<td align="right">£{{ $sms_confirmation_fee }}</td>
					<td align="right">£{{ $cancellation_waiver }}</td>
					<td align="right">£{{ $affiliate_cost }}</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="10">No data found!</td>
			</tr>
		@endif
		</tbody>

		<tfoot>
		<tr>
			<td colspan="3">Total</td>
			<td align="right">£{{ $total_order_value }}</td>
			<td align="right">£{{ $total_price_value }}</td>
			<td align="right">£{{ $total_revenue_share }}</td>
			<td align="right">£{{ $total_booking_fee }}</td>
			<td align="right">£{{ $total_sms_confirmation_fee }}</td>
			<td align="right">£{{ $total_cancellation_waiver }}</td>
			<td align="right">£{{ $total_affiliate_cost }}</td>
		</tr>
		<tr>
			<td colspan="9">Grand Total</td>
			<td>£{{ $total_revenue_share + $total_booking_fee + $total_sms_confirmation_fee + $total_cancellation_waiver + $total_affiliate_cost }}</td>
		</tr>
		</tfoot>
	</table>
</html>