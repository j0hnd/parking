<div class="row padding-15">
	<div class="col-md-12 bg-info">
		<form id="report-form" class="padding-5 margin-top10" method="post">
			<div class="col-md-3">
				<div class="form-group">
					<label>Date</label>
					<div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
						<i class="fa fa-calendar"></i>&nbsp;
						<span></span> <i class="fa fa-caret-down"></i>
					</div>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<label>Vendor</label>
					<select name="vendor" id="" class="form-control">
						<option value="" readonly>Select Vendor</option>
						@if($vendors)
							@foreach($vendors as $vendor)
								@if($selected_vendor == $vendor->id)
									<option value="{{ $vendor->id }}" selected>{{ $vendor->name }}</option>
								@else
									<option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
								@endif
							@endforeach
						@endif
					</select>
				</div>
			</div>

			<div class="col-md-5 text-right margin-top25">
				<button id="toggle-generate-report" type="button" class="btn btn-primary btn-flat" data-url="{{ $generate_url }}">Generate Report</button>
				@if(count($bookings))
				<button id="toggle-export-report" type="button" class="btn btn-primary btn-flat" data-url="{{ url('/admin/reports/export') }}">Export Report</button>
				<div class="checkbox">
					<label><input type="checkbox" name="is_pdf">Export as PDF</label>
				</div>
				<input type="hidden" name="export" value="{{ $export }}">
				@else
				<button id="toggle-export-report" type="button" class="btn btn-primary btn-flat disabled" disabled>Export Report</button>
				@endif
			</div>

			{{ csrf_field() }}

			@if(empty($start) and empty($end))
			<input type="hidden" id="date" name="date">
			@else
			<input type="hidden" id="date" name="date" value="{{ $start.':'.$end }}">
			@endif
		</form>
	</div>
</div>
