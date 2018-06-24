@if(count($products))
	@foreach($products as $product)
		<tr>
			<td><a href="javascript:void(0);" class="update-price" data-id="{{ $product->price_id }}">{{ $product->price_id }}</a></td>
			<td>{{ $product->airport_name }}</td>
			<td>{{ $product->carpark_name }}</td>
			<td>{{ $product->category_name }}</td>
			<td class="text-center">{{ $product->no_of_days }}</td>
			<td class="text-center">{{ $product->price_month }}</td>
			<td class="text-center">{{ $product->price_year }}</td>
			<td class="text-right">£{{ number_format($product->price_value, 2) }}</td>
		</tr>
	@endforeach
@else
	<tr>
		<td colspan="7">No Products posted</td>
	</tr>
@endif