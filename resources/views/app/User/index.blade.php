@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/users/create') }}" class="btn bg-navy btn-flat">Register New User</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <form action="{{ url('/admin/users/search') }}" method="post">
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date Added</th>
                            <th></th>
                        </tr>
                        @if(count($registered_users))
                            @foreach($registered_users as $reg)
                            <tr>
                                <td>
                                    @php($member = json_decode($reg->members, true))
                                    {{ $member['last_name'] }}, {{ $member['first_name'] }}
                                </td>
                                <td>{{ $reg->email }}</td>
                                <td>{{ $reg->roles[0]->name }}</td>
                                <td>{{ $reg->created_at->format('m/d/Y') }}</td>
                                <td>
                                    <a href="{{ url('/admin/users/'.$reg->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                    <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $reg->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No users listed</td>
                            </tr>
                        @endif
                        </tbody>
                        @if(count($registered_users))
                        <tfoot>
                            <tr>
                                <td colspan="5" style="padding-right: 20px; text-align: right;">{{ $registered_users->links() }}</td>
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
        if (confirm('Delete the selected user?')) {
            $.ajax({
                url: '/admin/users/' + id + '/delete',
                type: 'post',
                data: { _token: '{{ csrf_token() }}' },
                dataType: 'json',
                success: function (response) {
                    if (response) {
                        window.location = '/admin/users';
                    }
                }
            });
        }
    });
});
</script>
@stop
