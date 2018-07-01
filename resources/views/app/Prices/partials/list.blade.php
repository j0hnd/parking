@if(count($requests->get()))
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

	@foreach($requests->get() as $request)
		<tr>
			<td>{{ $request->order_title }}</td>
			<td class="text-center">{{ $request->no_of_days }}</td>
			<td class="text-center">{{ (is_null($request->price_month)) ? "-" : $months[$request->price_month] }}</td>
			<td class="text-center">{{ (is_null($request->price_year)) ? "-" : $request->price_year }}</td>
			<td class="text-center">{{ (is_null($request->price_value)) ? "-" : "£".number_format($request->price_value, 2) }}</td>
			<td class="text-center bg-gray-light">{{ $request->request_no_of_days }}</td>
			<td class="text-center bg-gray-light">{{ (is_null($request->request_price_month)) ? "-" : $months[$request->request_price_month] }}</td>
			<td class="text-center bg-gray-light">{{ (is_null($request->request_price_year)) ? "-" : $request->request_price_year }}</td>
			<td class="text-center bg-gray-light">{{ (is_null($request->request_price_value)) ? "-" : "£".number_format($request->request_price_value, 2) }}</td>
			<td>
				<button type="button" id="toggle-approve" class="btn bg-green btn-flat" data-id="{{ $request->price_id }}"><i class="fa fa-check" aria-hidden="true"></i></button>
				<button type="button" id="toggle-decline" class="btn bg-red btn-flat" data-id="{{ $request->price_id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
			</td>
		</tr>
	@endforeach
@else
	<tr>
		<td class="text-center" colspan="10">No price change requests</td>
	</tr>
@endif