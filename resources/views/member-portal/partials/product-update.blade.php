<form id="update-form" method="post">
	<div class="form-group">
		<label for="recipient-name" class="col-form-label">No Of Days:</label>
		<select name="no_of_days" id="" class="form-control">
			<option value="" readonly>-- No. of days --</option>
			@for($i = 1; $i <= 31; $i++)
				@if($i == $price->no_of_days)
				<option value="{{ $i }}" selected>{{ $i }}</option>
				@else
				<option value="{{ $i }}">{{ $i }}</option>
				@endif
			@endfor
		</select>
	</div>
	<div class="form-group">
		<label for="message-text" class="col-form-label">Month</label>
		<select name="price_month" id="" class="form-control">
			<option value="" readonly>-- Month --</option>
			<option value="1" {{ $price->price_month == 1 ? "selected" : "" }}>January</option>
			<option value="2" {{ $price->price_month == 2 ? "selected" : "" }}>February</option>
			<option value="3" {{ $price->price_month == 3 ? "selected" : "" }}>March</option>
			<option value="4" {{ $price->price_month == 4 ? "selected" : "" }}>April</option>
			<option value="5" {{ $price->price_month == 5 ? "selected" : "" }}>May</option>
			<option value="6" {{ $price->price_month == 6 ? "selected" : "" }}>June</option>
			<option value="7" {{ $price->price_month == 7 ? "selected" : "" }}>July</option>
			<option value="8" {{ $price->price_month == 8 ? "selected" : "" }}>August</option>
			<option value="9" {{ $price->price_month == 9 ? "selected" : "" }}>September</option>
			<option value="10" {{ $price->price_month == 10 ? "selected" : "" }}>October</option>
			<option value="11" {{ $price->price_month == 11 ? "selected" : "" }}>November</option>
			<option value="12" {{ $price->price_month == 12 ? "selected" : "" }}>December</option>
		</select>
	</div>
	<div class="form-group">
		<label for="message-text" class="col-form-label">Year</label>
		<select name="price_year" id="" class="form-control">
			<option value="" readonly>-- Year --</option>
			@for($i = date('Y'); $i <= date('Y') + 8; $i++)
				@if($i == $price->price_year)
				<option value="{{ $i }}" selected>{{ $i }}</option>
				@else
				<option value="{{ $i }}">{{ $i }}</option>
				@endif
			@endfor
		</select>
	</div>
	<div class="form-group">
		<label for="recipient-name" class="col-form-label">Fee:</label>
		<input type="text" class="form-control" name="price_value" value="{{ $price->price_value }}">
	</div>

	<input type="hidden" id="price_id" name="price_id" value="{{ $price->id }}">
	<input type="hidden" name="id" value="{{ $user->id }}">
	{{ csrf_field() }}
</form>