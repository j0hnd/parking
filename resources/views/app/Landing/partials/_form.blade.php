<div class="box-body">
    <div class="form-group">
		<label class="col-sm-2 control-label">Airport</label>
		<div class="col-sm-9">
			<select class="form-control" id="airports" name="airport_id">
                <option value="">-- Select Airport --</option>
				@if($airports->count())
					@foreach($airports->get() as $airport)
						@if(isset($page))
						<option value="{{ $airport->id }}" {{ $page->airport_id == $airport->id ? 'selected' : '' }}>{{ $airport->airport_name }}</option>
						@else
						<option value="{{ $airport->id }}">{{ $airport->airport_name }}</option>
						@endif
					@endforeach
				@endif
            </select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Name</label>
		<div class="col-sm-9">
			<input type="text" class="form-control disabled" name="name" placeholder="Name" value="{{ isset($page) ? $page->name : "" }}">
		</div>
	</div>

	@if(isset($page))
	<div class="form-group">
		<label class="col-sm-2 control-label">Slug</label>
		<div class="col-sm-9">
			<input type="text" class="form-control disabled" value="{{ $page->slug }}" readonly>
		</div>
	</div>
	@endif

	<div class="form-group">
		<label class="col-sm-2 control-label">Description</label>
		<div class="col-sm-9">
			<textarea id="content" name="description_1" class="form-control" cols="30" rows="30">{{ isset($page) ? $page->description_1 : "" }}</textarea>
		</div>
	</div>
</div>
