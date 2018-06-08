@extends('admin_template')

@section('styles')
<style type="text/css">
	#summary td {
		font-size: 18px;
	}
</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'company_revenues', 'generate_url' => url('/admin/reports/company/revenues')])

	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive">
				@php
					$total = 0;
				@endphp
				<table class="table table-striped">
					<thead>
					<tr>
						<th class="col-md-2">Vendor</th>
						<th class="col-md-3 text-right">Revenue</th>
						<th class="col-md-7"></th>
					</tr>
					</thead>

					<tbody>
					@if(count($bookings))
						@foreach($bookings as $booking)

							@php
								$total += $booking->revenue;
							@endphp

						<tr id="booking-{{ $booking->id }}">
							<td>{{ $booking->company_name }}</td>
							<td class="text-right">£{{ number_format($booking->revenue, 2) }}</td>
							<td></td>
						</tr>
						@endforeach

						<tr id="summary" class="bg-aqua">
							<td></td>
							<td class="text-right"><strong>£{{ number_format($total, 2) }}</strong></td>
							<td></td>
						</tr>
					@else
						<tr>
							<td colspan="2" class="text-center"><strong>No data found</strong></td>
						</tr>
					@endif
					</tbody>

					@if(count($bookings))
						<tfoot>
						<tr>
							<td colspan="2" class="text-right">{{ $bookings->links() }}</td>
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