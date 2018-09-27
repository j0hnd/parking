@php
	$months = [
		'January'   => 'January',
		'February'  => 'February',
		'March'     => 'March',
		'April'     => 'April',
		'May'       => 'May',
		'June'      => 'June',
		'July'      => 'July',
		'August'    => 'August',
		'September' => 'September',
		'October'   => 'October',
		'November'  => 'November',
		'December'  => 'December',
	];
@endphp

@if(count($prices))
	@foreach($prices as $i => $price)
		<tr data-id="{{ $price->product_id }}">
			<td>{{ $price->price_id }}</td>
			<td class="text-center">{{ $price->no_of_days }}</td>
			<td class="text-center">{{ is_null($price->price_month) ? "--" : $months[$price->price_month] }}</td>
			<td class="text-center">{{ is_null($price->price_year) ? "--" : $price->price_year }}</td>
			<td class="text-right"><a href="javascript:void(0);" class="update-price" data-id="{{ $price->price_id }}">£{{ number_format($price->price_value, 2) }}</a></td>
		</tr>
	@endforeach
@else
	<tr>
		<td colspan="6" class="text-center">No prices posted</td>
	</tr>
@endif