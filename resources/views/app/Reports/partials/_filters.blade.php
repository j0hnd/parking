<div class="row padding-15">
	<div class="col-md-12 bg-info">
		<form class="padding-5 margin-top10">
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
					<select name="" id="" class="form-control">
						<option value="" readonly>Select Vendor</option>
						@if($vendors)
							@foreach($vendors as $vendor)
							<option value="{{ $vendor->id }}">{{ $vendor->company_name }}</option>
							@endforeach
						@endif
					</select>
				</div>
			</div>

			<div class="col-md-5 text-right margin-top25">
				<button class="btn btn-primary btn-flat">Generate Report</button>
				<button class="btn btn-primary btn-flat disabled" disabled>Export Report</button>
			</div>
		</form>
	</div>
</div>
