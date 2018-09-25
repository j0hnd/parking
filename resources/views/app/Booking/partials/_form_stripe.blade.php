<div class="row">
	<div class="col-xs-12">
		<div class="form-group">
			<label class="col-sm-2 control-label">Card Name</label>

			<div class="col-sm-9">
				<input type="text" class="form-control" id="card-name"
					   name="ccard[card_name]"
					   placeholder="Card Name"
					   autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Card Number</label>

			<div class="col-sm-9">
				<input type="text" class="form-control" id="card-number"
					   name="ccard[card_number]"
					   placeholder="Card Number"
					   autocomplete="off">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Expiry Date</label>

			<div class="col-sm-3">
				<select name="ccard[expiry_date_month]" id="expiry-date-month" class="form-control">
					<option value="">Select Month</option>
					<option value="1">January</option>
					<option value="2">February</option>
					<option value="3">March</option>
					<option value="4">April</option>
					<option value="5">May</option>
					<option value="6">June</option>
					<option value="7">July</option>
					<option value="8">August</option>
					<option value="9">September</option>
					<option value="10">October</option>
					<option value="11">November</option>
					<option value="12">December</option>
				</select>
			</div>
			<div class="col-sm-3">
				<select name="ccard[expiry_date_year]" id="expiry-date-year" class="form-control">
					<option value="">Select Year</option>
					@for($i = 1; $i <= 10; $i++)
					<option value="{{ date('Y') + $i }}">{{ date('Y') + $i }}</option>
					@endfor
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label">Security No. (CVV)</label>

			<div class="col-sm-3">
				<input type="text" class="form-control" id="cvv"
					   name="ccard[cvv]"
					   placeholder="CVV"
					   autocomplete="off">
			</div>
		</div>
	</div>
</div>