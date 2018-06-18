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
							<th>Date Published</th>
							<th></th>
						</tr>
						@if(count($posts))
							@foreach($posts as $post)
								<tr>
									<td><a href="{{ url('/admin/post/'.$post->id.'/edit') }}">{{ $post->id }}</a></td>
									<td>{{ $post->title }}</td>
									<td>{{ ucfirst($post->status) }}</td>
									<td>{{ $post->created_at->format('m/d/Y') }}</td>
									<td>
										@if(strtotime($post->published))
										{{ $post->date_published->format('m/d/Y') }}
										@else
										<span class="bg-warning padding-5">Not Published</span>
										@endif
									</td>
									<td>
										<a href="{{ url('/admin/posts/'.$post->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										@if($post->status == 'draft')
										<button type="button" id="toggle-publish" class="btn bg-aqua btn-flat" data-id="{{ $post->id }}" data-value="published"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></button>
										@else
										<button type="button" id="toggle-publish" class="btn bg-red btn-flat" data-id="{{ $post->id }}" data-value="draft"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
										@endif
										<button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $post->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
									</td>
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
