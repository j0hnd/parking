@extends('admin_template')

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'company_revenues', 'generate_url' => url('/admin/reports/company/revenues')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th class="col-md-2">Vendor</th>
						<th class="col-md-10">Revenue</th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@foreach($bookings as $booking)
							<tr id="booking-{{ $booking->id }}">
								<td>{{ $booking->company_name }}</td>
								<td>£{{ number_format($booking->revenue, 2) }}</td>
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