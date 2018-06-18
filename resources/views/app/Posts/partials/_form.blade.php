<div class="box-body">
	<div class="form-group">
		<label class="col-sm-2 control-label">Title</label>
		<div class="col-sm-9">
			<input type="text" class="form-control disabled" name="title" placeholder="Title" value="{{ isset($post) ? $post->title : "" }}">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Content</label>
		<div class="col-sm-9">
			<textarea id="content" name="content" class="form-control" cols="30" rows="30">{{ isset($post) ? $post->content : "" }}</textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">Upload Image</label>

		<div class="col-sm-4">
			<input type="file" class="form-control margin-bottom10" name="image">
			@if(!empty($post->image))
				<a href="{{ URL::asset($post->image) }}" target="_blank">
					<img src="{{ asset($post->image) }}" style="max-width: 30%" alt="Post Image">
				</a>
			@endif
		</div>

		@if(isset($post))
		<input type="hidden" name="id" value="{{ $post->id }}">
		@endif
	</div>
</div>