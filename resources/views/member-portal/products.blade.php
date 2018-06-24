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
								<th>#</th>
								<th>Airport</th>
								<th>Carpark</th>
								<th>Type</th>
								<th class="text-center">No. Of Days</th>
								<th class="text-center">Month</th>
								<th class="text-center">Year</th>
								<th class="text-right">Fee</th>
							</tr>
							</thead>

							<tbody id="products-list">
							@include('member-portal.partials.product-list', compact('products'))
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

		<!-- Modal -->
		<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLongTitle">Update Price</h3>
						{{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
							{{--<span aria-hidden="true">&times;</span>--}}
						{{--</button>--}}
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="toggle-update">Update</button>
					</div>
				</div>
			</div>
		</div>

	@include('parking.templates.footer')
@stop

@section('js')
<script type="text/javascript">
$(function() {
    $(document).on('click', '.update-price', function (e) {
        var _id = $(this).data('id');
        $.ajax({
			url: "{{ url('/members/price') }}/" + _id,
			type: "get",
			dataType: "json",
			success: function (response) {
			    $('#updateModal').modal('toggle');
			    setTimeout(function () {
			        $('#updateModal').find('.modal-body').html(response.form);
                    $('#updateModal').find('#toggle-update').data('id', _id);
				}, 300);
			}
		});
    });

    $(document).on('click', '#toggle-update', function (e) {
        var _id = $(this).data('id');
		$.ajax({
            url: "{{ url('/members/price') }}/" + _id,
			type: "post",
			data: $('#update-form').serialize(),
			dataType: "json",
			success: function (response) {
                if (response.success) {
                    $('#updateModal').modal('hide');
                    setTimeout(function () {
                        $('#products-list').html(response.html);
                        alert('Selected price is updated');
					}, 300);
				} else {
                    alert(response.message);
				}
			}
		});
    });
});
</script>
@stop
