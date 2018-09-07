@if(count($pages))
	@foreach($pages as $i => $page)
		<tr>
			<td>{{ $i + 1 }}</td>
			<td>{{ $page->airport->airport_name }}</td>
			<td> <a href="{{ url('/landing/' . $page->slug) }}" target="_blank">{{ url('/landing/' . $page->slug) }}</a> </td>
			<td>{{ $page->created_at->format('d/m/Y') }}</td>
			<td>
				<a href="{{ url('/admin/landing/pages/'.$page->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
				@if(is_null($page->deleted_at))
				<button type="button" id="toggle-status" class="btn bg-green btn-flat" data-id="{{ $page->id }}" data-status="enabled" title="Disabled this page"><i class="fa fa-toggle-on" aria-hidden="true"></i></button>
				@else
				<button type="button" id="toggle-status" class="btn bg-gray btn-flat" data-id="{{ $page->id }}" data-status="disabled" title="Disabled this page"><i class="fa fa-toggle-off" aria-hidden="true"></i></button>
				@endif
			</td>
		</tr>
	@endforeach
@else
	<tr>
		<td colspan="5" class="text-center">No posts listed</td>
	</tr>
@endif
