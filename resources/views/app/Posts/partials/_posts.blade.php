@if(count($posts))
	@foreach($posts as $post)
		<tr>
			<td><a href="{{ url('/admin/post/'.$post->id.'/edit') }}">{{ $post->id }}</a></td>
			<td>{{ $post->title }}</td>
			<td>{{ ucfirst($post->status) }}</td>
			<td>{{ $post->created_at->format('m/d/Y') }}</td>
			<td>
				@if(strtotime($post->date_published))
					{{ date('m/d/Y', strtotime($post->date_published)) }}
				@else
					<span class="bg-warning padding-5">Not Published</span>
				@endif
			</td>
			<td>
				<a href="{{ url('/admin/posts/'.$post->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				@if($post->status == 'draft')
					<button type="button" id="toggle-status" class="btn bg-aqua btn-flat" data-id="{{ $post->id }}" data-value="published"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></button>
				@else
					<button type="button" id="toggle-status" class="btn bg-red btn-flat" data-id="{{ $post->id }}" data-value="draft"><i class="fa fa-chevron-circle-down" aria-hidden="true"></i></button>
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