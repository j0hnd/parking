@extends('admin_template')

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'completed_jobs', 'generate_url' => url('/admin/reports/completed/jobs')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>Booking ID</th>
						<th>Vendor</th>
						<th>Airport/Parking Type</th>
						<th class="text-center">Booking Fee</th>
						<th class="text-center">Expected Date of Completion</th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@foreach($bookings as $booking)
						<tr id="booking-{{ $booking->id }}">
							<td>{{ $booking->booking_id }}</td>
							<td>{{ $booking->products[0]->vendors[0]->company_name }}</td>
							<td>{{ $booking->order_title }}</td>
							<td class="text-center">£{{ number_format($booking->price_value, 2) }}</td>
							<td class="text-center">{{ $booking->return_at->format('F j, Y') }}</td>
						</tr>
						@endforeach
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
@stop