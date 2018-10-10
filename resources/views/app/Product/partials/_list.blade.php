@if(count($products))
	@foreach($products as $product)
		@if(isset($product->airport[0]))
			@if(is_null($product->airport[0]->deleted_at))
				<tr>
					<td>
						@php($carpark = json_decode($product->carpark, true))
						{{ $carpark['name'] }}
					</td>
					<td>
						<ul>
							<li>{{ $product->airport[0]->airport_name }}</li>
						</ul>
					</td>
					<td>{{ $product->prices[0]->categories->category_name }}</td>
					<td>
						<a href="{{ url('/admin/product/'.$product->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
						<button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $product->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
						@if(is_null($product->deactivated_at))
							<button type="button" class="btn bg-gray btn-flat toggle-product" data-id="{{ $product->id }}" data-status="deactivate" title="Enabled"><i class="fa fa-pause" aria-hidden="true"></i></button>
						@else
							<button type="button" class="btn bg-gray-light btn-flat toggle-product" data-id="{{ $product->id }}" data-status="activate" title="Deactivated on {{ date('d/m/Y', strtotime($product->deactivated_at)) }}"><i class="fa fa-play" aria-hidden="true"></i></button>
						@endif
					</td>
				</tr>
			@endif
		@endif
	@endforeach
@else
	<tr>
		<td colspan="4" class="text-center">No products listed</td>
	</tr>
@endif