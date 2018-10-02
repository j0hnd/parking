<div id="closed-date-container" class="row">
	<div class="row margin-left10">
		<div class="col-md-4"> <h4>Closed Date</h4> </div>
		<div class="col-md-1"> </div>
	</div>

	@if(count($product->closures))
		@foreach($product->closures as $i => $closure)
			@if($i == 0)
			<div id="first-row-cd" class="row margin-bottom10 margin-left10">
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control closed_date" name="closure[date][]" value="{{ $closure->closed_date }}" style="background-color: #ffffff;" readonly>
					</div>
					<small>Date</small>
				</div>

				<div class="col-md-1">
					<div class="btn-group">
						<button type="button" class="btn btn-success btn-flat toggle-create-row-cd">
							<i class="fa fa-plus"></i>
						</button>
						<button type="button" class="btn btn-warning btn-flat toggle-remove-row-cd">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</div>
			</div>
			@else
			<div class="row margin-bottom10 margin-left10">
				<div class="col-md-4">
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control closed_date" name="closure[date][]" value="{{ $closure->closed_date }}" style="background-color: #ffffff;" readonly>
					</div>
					<small>Date</small>
				</div>
				<div class="col-md-1">
					<div class="btn-group">
						<button type="button" class="btn btn-success btn-flat toggle-create-row-cd">
							<i class="fa fa-plus"></i>
						</button>
						<button type="button" class="btn btn-warning btn-flat toggle-remove-row-cd">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</div>
			</div>
			@endif
		@endforeach
	@else
	<div id="first-row-cd" class="row margin-bottom10 margin-left10">
		<div class="col-md-4">
			<div class="input-group">
				<div class="input-group-addon">
					<i class="fa fa-calendar"></i>
				</div>
				<input type="text" class="form-control closed_date" name="closure[date][]" style="background-color: #ffffff;" readonly>
			</div>
			<small>Date</small>
		</div>
		<div class="col-md-1">
			<div class="btn-group">
				<button type="button" class="btn btn-success btn-flat toggle-create-row-cd">
					<i class="fa fa-plus"></i>
				</button>
				<button type="button" class="btn btn-warning btn-flat toggle-remove-row-cd">
					<i class="fa fa-trash-o"></i>
				</button>
			</div>
		</div>
	</div>
	@endif
</div>

