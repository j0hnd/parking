@extends('admin_template')
@section('main-content')
	<div class="row">
		<div class="col-xs-12">
			@include('common.flash')
			<div class="box">
				<div class="box-header">
					<a href="{{ url('/admin/posts/create') }}" class="btn bg-navy btn-flat">Add Post</a>

					{{--<div class="box-tools" style="margin-top: 7px">--}}
						{{--<form action="{{ url('/admin/booking/search') }}" method="post">--}}
							{{--<div class="input-group input-group-sm" style="width: 150px;">--}}
								{{--<input type="text" name="search" class="form-control pull-right" placeholder="Search">--}}

								{{--<div class="input-group-btn">--}}
									{{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
								{{--</div>--}}
							{{--</div>--}}
							{{--{{ csrf_field() }}--}}
						{{--</form>--}}
					{{--</div>--}}
				</div>

				<div class="box-body table-responsive no-padding">
					<table class="table table-hover">
						<thead>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Status</th>
							<th>Date Posted</th>
							<th>Date Published</th>
							<th></th>
						</tr>
						</thead>

						<tbody id="posts-container">
							@include('app.Posts.partials._posts')
						</tbody>
						@if(count($posts))
							<tfoot>
							<tr>
								<td colspan="5">{{ $posts->links() }}</td>
							</tr>
							</tfoot>
						@endif
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
		    var value = $(this).data('value');
		    $.ajax({
				url: "{{ url('/admin/posts/update/status') }}/" + id,
				type: 'post',
				data: { _token: "{{ csrf_token() }}", status: value },
				dataType: 'json',
				success: function (response) {
				    if (response.success) {
                        $('#posts-container').html(response.html);
                        alert('Your post has been updated');
					} else {
				        alert(response.message);
					}
				}
			});
		});
    });
</script>
@stop
