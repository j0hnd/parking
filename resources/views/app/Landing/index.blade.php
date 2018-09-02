@extends('admin_template')
@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')
			<div class="box">
				<div class="box-header">
					<a href="{{ url('/admin/landing/pages/create') }}" class="btn bg-navy btn-flat">Create Landing Page</a>
				</div>

				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Airport</th>
							<th>URL</th>
							<th>Date Created</th>
							<th></th>
						</tr>
						</thead>

						<tbody id="landing-page-container">
							@include('app.Landing.partials._list')
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
<script type="text/javascript">
	$(function () {
		$(document).on('click', '#toggle-status', function (e) {
			e.preventDefault();
            var id = $(this).data('id');
            if (confirm("Update status of this landing page?")) {
                $.ajax({
                    url: "{{ url('/admin/landing/pages/status') }}/" + id,
                    type: 'post',
                    data: { _token: "{{ csrf_token() }}", status: $(this).data('status') },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#landing-page-container').html(response.html);
                            alert('Landing page has been updated');
                        } else {
                            alert(response.message);
                        }
                    }
                });
			}
		});
    });
</script>
@stop
