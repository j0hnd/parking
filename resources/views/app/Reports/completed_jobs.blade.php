@extends('admin_template')

@section('styles')
	<style type="text/css">
		#summary td {
			font-size: 18px;
		}

		#grand-total {
			font-size: 22px;
			font-weight: bold;
		}

		#grand-total span {
			font-weight: normal;
			font-size: 11px;
			padding-right: 10px;
		}
	</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'completed_jobs', 'generate_url' => url('/admin/reports/completed/jobs')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				@php
					$total_sales = 0;
					$total_revenue = 0;
					$total_booking_fee = 0;
					$total_sms_fee = 0;
					$total_cancellation_fee = 0;
				@endphp
				<table class="table">
					<thead>
					<tr>
						<th>Vendor</th>
						<th class="text-right">Sales</th>
						<th class="text-right">Revenue</th>
						<th class="text-right">Booking Fee</th>
						<th class="text-right">SMS Confirmation</th>
						<th class="text-right">Cancellation Waiver</th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@foreach($bookings as $i => $booking)

							@php
								$color = ($i % 2) == 0 ? "#ffffff" : "#f4f4f4";
								$total_sales += $booking->sales;
								$total_revenue += $booking->revenue;
								$total_booking_fee += $booking->booking_fee;
								$total_sms_fee += $booking->sms_fee;
								$total_cancellation_fee += $booking->cancellation;
							@endphp

						<tr id="booking-{{ $booking->company_id}}" style="background-color:{{ $color }}">
							<td><a href="javascript:void(0);" class="toggle-booking-details" data-id="{{ $booking->company_id }}" data-date="{{ $selected_date }}">{{ $booking->company_name }}</a></td>
							<td class="text-right">£{{ number_format($booking->sales, 2) }}</td>
							<td class="text-right">£{{ number_format($booking->revenue, 2) }}</td>
							<td class="text-right">£{{ number_format($booking->booking_fee, 2) }}</td>
							<td class="text-right">£{{ number_format($booking->sms_fee, 2) }}</td>
							<td class="text-right">£{{ number_format($booking->cancellation, 2) }}</td>
						</tr>
						<tr id="booking-details-{{ $booking->company_id }}" class="booking-details hidden bg-gray">
							<td colspan="6">
								<div class="row">
									<div class="col-md-12"><h4>Booking Details</h4></div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<table class="table table-striped">
											<thead>
											<tr>
												<th>Booking ID</th>
												<th>Airport/Parking Type</th>
												<th class="text-right">Booking Fee</th>
												<th class="text-right">SMS Confirmation Fee</th>
												<th class="text-right">Cancellation Waiver</th>
												<th class="text-center">Revenue Share</th>
												<th class="text-right">Revenue Value</th>
											</tr>
											</thead>

											<tbody id="details-{{ $booking->company_id }}-wrapper">
												<tr><td class="text-center" colspan="7"><img src="{{ asset('/img/loader.gif') }}"></td></tr>
											</tbody>
										</table>
									</div>
								</div>
							</td>
						</tr>
						@endforeach

						<tr id="summary" class="bg-aqua">
							<td></td>
							<td class="text-right"><strong>£{{ number_format($total_sales, 2) }}</strong></td>
							<td class="text-right"><strong>£{{ number_format($total_revenue, 2) }}</strong></td>
							<td class="text-right"><strong>£{{ number_format($total_booking_fee, 2) }}</strong></td>
							<td class="text-right"><strong>£{{ number_format($total_sms_fee, 2) }}</strong></td>
							<td class="text-right"><strong>£{{ number_format($total_cancellation_fee, 2) }}</strong></td>
						</tr>
						<tr>
							<td id="grand-total" class="text-right" colspan="6">
								@php
									$grand_total = $total_sales + $total_revenue + $total_booking_fee + $total_sms_fee + $total_cancellation_fee;
								@endphp
								<span>Grand Total:</span> £{{ number_format($grand_total, 2) }}
							</td>
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

	<input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
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