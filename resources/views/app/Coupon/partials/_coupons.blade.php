@if(count($promocodes))
    @foreach($promocodes as $promocode)
        @if(strtotime(date('Y-m-d')) < strtotime($promocode->expiry_date))
        <tr>
            <td>{{ $promocode->code }}</td>
            <td>{{ $promocode->reward * 100 }}%</td>
            <td>{{ date('d/m/Y', strtotime($promocode->expiry_date)) }}</td>
            <td>
                <a href="{{ url('/admin/coupons/'.$promocode->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $promocode->id }}" title="Delete this post"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
            </td>
        </tr>
        @endif
    @endforeach
@endif
