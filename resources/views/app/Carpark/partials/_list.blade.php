@if(count($carparks))
    @foreach($carparks as $carpark)
        <tr>
            <td>{{ $carpark->name }}</td>
            <td>{{ $carpark->company->company_name }}</td>
            <td>{{ $carpark->city }}</td>
            <td>{{ $carpark->county_state }}</td>
            <td>
                <a href="{{ url('/admin/carpark/'.$carpark->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                @if(is_null($carpark->deactivated_at))
                    <button type="button" class="btn bg-gray btn-flat toggle-carpark" data-id="{{ $carpark->id }}" data-status="deactivate" title="Enabled"><i class="fa fa-pause" aria-hidden="true"></i></button>
                @else
                    <button type="button" class="btn bg-gray-light btn-flat toggle-carpark" data-id="{{ $carpark->id }}" data-status="activate" title="Deactivated on {{ date('d/m/Y', strtotime($carpark->deactivated_at)) }}"><i class="fa fa-play" aria-hidden="true"></i></button>
                @endif
                <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $carpark->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">No carpark listed</td>
    </tr>
@endif
