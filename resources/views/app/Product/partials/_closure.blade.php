<div id="closed-date-container" class="row">
	<div class="row margin-left10">
		<div class="col-md-4"> <h4>Closed Date</h4> </div>
		<div class="col-md-1"> </div>
	</div>

	@if(isset($product->closures))
		@foreach($product->closures as $i => $closure)
			@if($i == 0)
			<div id="first-row-cd" class="row margin-bottom10 margin-left10">
				<div class="col-md-4">
					<input type="text" name="closure[date][]"
						   class="form-control closed_date"
						   placeholder="Closure Date"
						   style="background-color: #FFFFFF"
						   value="{{ $closure->closed_date }}"
						   readonly>
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
					<input type="text" name="closure[date][]"
						   class="form-control closed_date"
						   placeholder="Closure Date"
						   style="background-color: #FFFFFF"
						   value="{{ $closure->closed_date }}"
						   readonly>
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
			<input type="text" name="closure[date][]"
				   class="form-control closed_date"
				   placeholder="Closure Date"
				   style="background-color: #FFFFFF"
				   readonly>
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

