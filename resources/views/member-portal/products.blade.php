@extends('member-portal')

@section('css')
	<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
@stop

@section('main-content')
	@include('member-portal.partials.nav-mobile')

	@include('member-portal.partials.nav-header')

	<br>

	<!-- PAGE CONTENT-->
	<div class="page-content--bgf7">
		<!-- BREADCRUMB-->
		@include('member-portal.partials.breadcrumbs', ['page_title' => 'Products'])
		<!-- END BREADCRUMB-->

		<!-- DATA TABLE-->
		<section class="p-t-20">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<table class="table table-data2">
							<thead>
								<tr>
									<th>Airport</th>
									<th>Carpark</th>
									<th>Type</th>
									<th>No. Of Days</th>
									<th>Month</th>
									<th>Year</th>
									<th>Fee</th>
								</tr>
							</thead>

							<tbody>
							@if(count($products))
								@foreach($products as $product)
								<tr>
									<td>{{ $product->airport_name }}</td>
									<td>{{ $product->carpark_name }}</td>
									<td>{{ $product->category_name }}</td>
									<td>{{ $product->no_of_days }}</td>
									<td>{{ $product->price_month }}</td>
									<td>{{ $product->price_year }}</td>
									<td>£{{ $product->price_value }}</td>
								</tr>
								@endforeach
							@else
							<tr>
								<td colspan="7">No Products posted</td>
							</tr>
							@endif
							</tbody>

							@if(count($products))
							<tfoot>
								<td colspan="7">{{ $products->links() }}</td>
							</tfoot>
							@endif
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" id="token" value="{{ csrf_token() }}">
		</section>
		<br/>
		<br/>
		<br/>

	@include('parking.templates.footer')
@stop