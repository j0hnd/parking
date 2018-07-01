@if(count($products))
	@foreach($products as $i => $product)
	<tr id="product-{{ $product->product_id }}" style="cursor: pointer">
		<td><a href="javascript:void(0);" class="update-price" data-id="{{ $product->product_id }}">{{ $i + 1 }}</a></td>
		<td>{{ $product->airport_name }}</td>
		<td>{{ $product->carpark_name }}</td>
		<td>{{ $product->category_name }}</td>
		<td>
			<button type="button" class="btn btn-primary update-product" data-id="{{ $product->product_id }}">Edit</button>
			<button type="button" class="btn btn-primary products" data-id="{{ $product->product_id }}">Price</button>
		</td>
	</tr>
	<tr id="product-details-{{ $product->product_id }}" class="product-details d-none">
		<td colspan="5" style="background-color: #97a0b3">
			<table class="table table-data2" style="background-color: #97a0b3">
				<thead>
				<tr>
					<th>#</th>
					<th class="text-center">No. Of Days</th>
					<th class="text-center">Month</th>
					<th class="text-center">Year</th>
					<th class="text-right">Fee</th>
				</tr>
				</thead>

				<tbody id="price-list-{{ $product->product_id }}"></tbody>
			</table>
		</td>
	</tr>
	@endforeach
@else
	<tr>
		<td colspan="5">No products posted</td>
	</tr>
@endif