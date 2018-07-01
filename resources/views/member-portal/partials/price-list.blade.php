@php
	$months = [
		1  => 'January',
		2  => 'February',
		3  => 'March',
		4  => 'April',
		5  => 'May',
		6  => 'June',
		7  => 'July',
		8  => 'August',
		9  => 'September',
		10 => 'October',
		11 => 'November',
		12 => 'December',
	];
@endphp

@if(count($prices))
	@foreach($prices as $i => $price)
		<tr data-id="{{ $price->product_id }}">
			<td><a href="javascript:void(0);" class="update-price" data-id="{{ $price->price_id }}">{{ $price->price_id }}</a></td>
			<td class="text-center">{{ $price->no_of_days }}</td>
			<td class="text-center">{{ is_null($price->price_month) ? "" : $months[$price->price_month] }}</td>
			<td class="text-center">{{ $price->price_year }}</td>
			<td class="text-right">£{{ number_format($price->price_value, 2) }}</td>
		</tr>
	@endforeach
@else
	<tr>
		<td colspan="4">No prices posted</td>
	</tr>
@endif