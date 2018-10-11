@if(count($airports))
    @foreach($airports as $airport)
    <tr>
        <td>{{ $airport->airport_name }}</td>
        <td>{{ $airport->city }}</td>
        <td>{{ $airport->county_state }}</td>
        <td>
            <a href="{{ url('/admin/airport/'.$airport->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            @if(is_null($airport->deactivated_at))
                <button type="button" class="btn bg-gray btn-flat toggle-airport" data-id="{{ $airport->id }}" data-status="deactivate" title="Enabled"><i class="fa fa-pause" aria-hidden="true"></i></button>
            @else
                <button type="button" class="btn bg-gray-light btn-flat toggle-airport" data-id="{{ $airport->id }}" data-status="activate" title="Deactivated on {{ date('d/m/Y', strtotime($airport->deactivated_at)) }}"><i class="fa fa-play" aria-hidden="true"></i></button>
            @endif
            <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $airport->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
        </td>
    </tr>
    @endforeach
@else
<tr>
    <td colspan="4" class="text-center">No airport listed</td>
</tr>
@endif