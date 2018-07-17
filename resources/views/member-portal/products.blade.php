@extends('member-portal')

@section('css')
	<link rel="stylesheet" href="{{ asset('bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css') }}">
	<link href="{{ asset('/css/member-portal.css') }}" rel="stylesheet">
	<style type="text/css">
		.update-price {
			text-decoration: underline;
		}
	</style>
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
								<th></th>
							</tr>
							</thead>

							<tbody id="products-list">
							@include('member-portal.partials.product-list', compact('products'))
							</tbody>
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
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="toggle-update-price">Update</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h3 class="modal-title" id="exampleModalLongTitle">Update Product</h3>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" id="toggle-update-product">Update</button>
					</div>
				</div>
			</div>
		</div>

	@include('parking.templates.footer')
@stop

@section('js')
<script src="{{ asset('bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.min.js') }}"></script>
<script type="text/javascript">
$(function() {
    $(document).on('click', '.products', function (e) {
		var id = $(this).data('id');

		$.ajax({
			url: "/members/products/" + id,
			type: "post",
			data: { _token: $('#token').val() },
			dataType: "json",
			success: function (response) {
                if ($('#product-details-' + id).is(':visible')) {
                    $('#product-details-' + id).addClass('d-none');
                } else {
                    $('.product-details').addClass('d-none');
                    $('#product-details-' + id).removeClass('d-none');
                    $('#price-list-' + id).html(response.html);
                }
			}
		});
    });

    $(document).on('click', '.update-product', function (e) {
        var _id = $(this).data('id');
        $.ajax({
            url: "/members/product/"+ _id +"/update",
            type: "get",
            dataType: "json",
            success: function (response) {
                $('#productModal').modal('toggle');
                setTimeout(function () {
                    $('#productModal').find('.modal-body').html(response.form);
                    $('#productModal').find('#toggle-update').data('id', _id);
                }, 300);
            }
        });
    });

    $(document).on('click', '#toggle-update-product', function (e) {
        var _id = $('#product_id').val();
        $.ajax({
            url: "/members/product/"+ _id +"/update",
            type: "post",
            data: $('#update-form').serialize(),
            dataType: "json",
            success: function (response) {
                $('#productModal').modal('toggle');
                alert(response.message);
                window.location = "/members/products";
            }
        });
    });

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

    $(document).on('click', '#toggle-update-price', function (e) {
        var _id = $('#price_id').val();
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
                        alert(response.message);
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
