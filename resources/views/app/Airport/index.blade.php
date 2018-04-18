@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/airport/create') }}" class="btn bg-navy btn-flat">Add Airport</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <form action="{{ url('/admin/airport/search') }}" method="post">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Airport Name</th>
                                <th>City</th>
                                <th>County/State</th>
                                <th></th>
                            </tr>
                            @if(count($airports))
                                @foreach($airports as $airport)
                                <tr>
                                    <td>{{ $airport->airport_name }}</td>
                                    <td>{{ $airport->city }}</td>
                                    <td>{{ $airport->county_state }}</td>
                                    <td>
                                        <a href="{{ url('/admin/airport/'.$airport->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $airport->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center">No airport listed</td>
                            </tr>
                            @endif
                        </tbody>
                        @if(count($airports))
                        <tfoot>
                            <tr>
                                <td colspan="4" style="padding-right: 20px; text-align: right;">{{ $airports->links() }}</td>
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
    $(document).on('click', '#toggle-delete', function (e) {
        var id = $(this).data('id');
        if (confirm('Delete the selected airport?')) {
            $.ajax({
                url: '/admin/airport/' + id + '/delete',
                type: 'post',
                data: { _token: '{{ csrf_token() }}' },
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        window.location = '/admin/airport';
                    }
                }
            });
        }
    });
});
</script>
@stop