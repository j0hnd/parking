@if(count($bookings))
	<div class="row margin-bottom20 margin-right15">
		<div class="col-md-11">&nbsp;</div>
		<div class="col-md-1">
			<label>Show more: </label>
			<select id="per-page-src" class="form-control">
				<option value="all" {{ $per_page == 'all' ? 'selected' : '' }}>All</option>
				<option value="{{ env('PER_PAGE') }}" {{ $per_page == env('PER_PAGE') ? 'selected' : '' }}>{{ env('PER_PAGE') }}</option>
				<option value="25" {{ $per_page == 25 ? 'selected' : '' }}>25</option>
				<option value="50" {{ $per_page == 50 ? 'selected' : '' }}>50</option>
				<option value="100" {{ $per_page == 100 ? 'selected' : '' }}>100</option>
			</select>
		</div>
	</div>
@endif