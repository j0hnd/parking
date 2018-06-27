<div class="box-body">
	<div class="form-group">
		<label class="col-sm-2 control-label">Travel Agents</label>

		<div class="col-sm-9">
			<select name="travel_agent_id" id="travel-agents" style="width: 100%">
				<option value="" readonly="">-- Travel Agents --</option>
				@if($travel_agents->count())
					@foreach($travel_agents->get() as $agent)
						@if(isset($affiliate))
							@if($agent->id == $affiliate->travel_agent_id)
								<option value="{{ $agent->id }}" selected>{{ $agent->members->first_name }} {{ $agent->members->last_name }}</option>
							@else
								<option value="{{ $agent->id }}">{{ $agent->members->first_name }} {{ $agent->members->last_name }}</option>
							@endif
						@else
							<option value="{{ $agent->id }}">{{ $agent->members->first_name }} {{ $agent->members->last_name }}</option>
						@endif
					@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Distributions (%)</label>

		<div class="col-sm-2">
			<input type="text" id="percent-admin" class="form-control margin-bottom10 percent" name="percent_admin" placeholder="Admin Percentage" autocomplete="off" value="{{ isset($affiliate) ? $affiliate->percent_admin : "" }}">
			<input type="text" id="percent-vendor" class="form-control margin-bottom10 percent" name="percent_travel_agent" placeholder="Travel Agent Percentage" autocomplete="off" value="{{ isset($affiliate) ? $affiliate->percent_travel_agent : "" }}">
		</div>
		<div class="col-md-2">
			<input type="text" class="form-control margin-bottom10" name="percent_vendor" placeholder="Vendor Percentage" autocomplete="off" value="{{ isset($affiliate) ? $affiliate->percent_vendor : "" }}">
			<small>Percentage of travel agents will be taken to the percentage of admin.</small>
		</div>
	</div>
</div>