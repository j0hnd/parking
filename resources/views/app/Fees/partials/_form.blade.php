<div class="box-body">
	<div class="form-group">
		<label class="col-sm-2 control-label">Fee</label>

		<div class="col-sm-9">
			<input type="text" class="form-control disabled" name="fee_name" placeholder="Fee Name" autocomplete="off" value="{{ isset($fee->fee_name) ? str_replace('_', ' ', ucwords($fee->fee_name)) : "" }}" disabled>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Amount</label>

		<div class="col-sm-9">
			<input type="text" class="form-control" name="amount" placeholder="Amount" autocomplete="off" value="{{ isset($fee->amount) ? $fee->amount : "0" }}">
		</div>
	</div>
</div>