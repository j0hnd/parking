@extends('admin_template')
@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')
			<div class="box">
				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<thead>
						<tr>
							<th></th>
							<th class="text-center bg-green" colspan="4">Current Price</th>
							<th class="text-center bg-yellow" colspan="4">Request Price Change</th>
							<th></th>
						</tr>
						<tr>
							<th>Product</th>
							<th class="text-center">No. Of Days</th>
							<th class="text-center">Month</th>
							<th class="text-center">Year</th>
							<th class="text-center">Price Value</th>
							<th class="text-center bg-gray-light">No. Of Days</th>
							<th class="text-center bg-gray-light">Month</th>
							<th class="text-center bg-gray-light">Year</th>
							<th class="text-center bg-gray-light">Price Value</th>
							<th></th>
						</tr>
						</thead>

						<tbody id="requests-list">
							@include('app.Prices.partials.list', compact('requests'))
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<input type="hidden" id="token" value="{{ csrf_token() }}">
	</div>
@stop

@section('scripts')
<script type="text/javascript">
	$(function () {
	    $(document).on('click', '#toggle-approve', function (e) {
			var id = $(this).data('id');
			$.ajax({
				url: "/admin/price/request/"+ id +"/approved",
				type: "post",
				data: { _token: $('#token').val() },
				dataType: "json",
				success: function (response) {
				    if (response.success) {
				        $('#requests-list').html(response.html);
					}

					alert(response.message);
				}
			});
		});

        $(document).on('click', '#toggle-decline', function (e) {
            var id = $(this).data('id');
            $.ajax({
                url: "/admin/price/request/"+ id +"/declined",
                type: "post",
                data: { _token: $('#token').val() },
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        $('#requests-list').html(response.html);
                    }

                    alert(response.message);
                }
            });
        });
	});
</script>
@stop