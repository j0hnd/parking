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
						<tbody>
						<tr>
							<th>#</th>
							<th>Title</th>
							<th>Status</th>
							<th>Date Posted</th>
							<th></th>
						</tr>
						@if(count($posts))
							@foreach($posts as $post)
								<tr>
									<td><a href="{{ url('/admin/post/'.$post->id.'/edit') }}">{{ $post->post_id }}</a></td>
									<td>{{ $post->title }}</td>
									<td>{{ ucfirst($post->status) }}</td>
									<td>{{ $post->created_at->format('m/d/Y') }}</td>
									<td></td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="5" class="text-center">No posts listed</td>
							</tr>
						@endif
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
