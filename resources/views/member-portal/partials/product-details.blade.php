<form id="update-form" method="post">
	<div class="form-group">
		<label for="message-text" class="col-form-label">Description</label>
		<textarea name="description" id="description" class="form-control" cols="30" rows="10">
            @if(isset($product))
			{{ $product->description }}
			@endif
        </textarea>
	</div>
	<div class="form-group">
		<label for="message-text" class="col-form-label">On Arrival</label>
		<textarea name="on_arrival" id="on_arrival" class="form-control" cols="30" rows="10">
            @if(isset($product))
			{{ $product->on_arrival }}
			@endif
        </textarea>
	</div>
	<div class="form-group">
		<label for="recipient-name" class="col-form-label">On Return</label>
		<textarea name="on_return" id="on_return" class="form-control" cols="30" rows="10">
            @if(isset($product))
			{{ $product->on_return }}
			@endif
        </textarea>
	</div>

	<input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
	{{ csrf_field() }}
</form>
<script>
    $('#description').wysihtml5();
    $('#on_arrival').wysihtml5();
    $('#on_return').wysihtml5();
</script>