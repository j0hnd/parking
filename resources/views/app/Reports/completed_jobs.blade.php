@extends('admin_template')

@section('styles')
	<style type="text/css">
		#summary td {
			font-size: 18px;
		}
	</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'completed_jobs', 'generate_url' => url('/admin/reports/completed/jobs')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				@php
					$total = 0;
				@endphp
				<table class="table table-striped">
					<thead>
					<tr>
						<th>Booking ID</th>
						<th>Vendor</th>
						<th>Airport/Parking Type</th>
						<th class="text-right">Booking Fee</th>
						<th class="text-center">Expected Date of Completion</th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@foreach($bookings as $booking)

							@php
								$total += $booking->price_value
							@endphp

						<tr id="booking-{{ $booking->id }}">
							<td>{{ $booking->booking_id }}</td>
							<td>{{ $booking->products[0]->vendors[0]->company_name }}</td>
							<td>{{ $booking->order_title }}</td>
							<td class="text-right">£{{ number_format($booking->price_value, 2) }}</td>
							<td class="text-center">{{ $booking->return_at->format('F j, Y') }}</td>
						</tr>
						@endforeach

						<tr id="summary" class="bg-aqua">
							<td></td>
							<td></td>
							<td></td>
							<td class="text-right"><strong>£{{ number_format($total, 2) }}</strong></td>
							<td></td>
						</tr>
					@else
						<tr>
							<td colspan="5" class="text-center"><strong>No data found</strong></td>
						</tr>
					@endif
					</tbody>

					@if(count($bookings))
						<tfoot>
						<tr>
							<td colspan="5" class="text-right">{{ $bookings->links() }}</td>
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