@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/carpark/create') }}" class="btn bg-navy btn-flat">Add Carpark</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <form action="{{ url('/admin/carpark/search') }}" method="post">
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
                            <th>Carpark Name</th>
                            <th>Company</th>
                            <th>City</th>
                            <th>County/State</th>
                            <th></th>
                        </tr>
                        @if(count($carparks))
                            @foreach($carparks as $carpark)
                                <tr>
                                    <td>{{ $carpark->name }}</td>
                                    <td>{{ $carpark->company->company_name }}</td>
                                    <td>{{ $carpark->city }}</td>
                                    <td>{{ $carpark->county_state }}</td>
                                    <td>
                                        <a href="{{ url('/admin/carpark/'.$carpark->id.'/edit') }}" class="btn bg-maroon btn-flat"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <button type="button" id="toggle-delete" class="btn bg-yellow btn-flat" data-id="{{ $carpark->id }}"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No carpark listed</td>
                            </tr>
                        @endif
                        </tbody>
                        @if(count($carparks))
                            <tfoot>
                            <tr>
                                <td colspan="5" style="padding-right: 20px; text-align: right;">{{ $carparks->links() }}</td>
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
                if (confirm('Delete the selected carpark?')) {
                    $.ajax({
                        url: '/admin/carpark/' + id + '/delete',
                        type: 'post',
                        data: { _token: '{{ csrf_token() }}' },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                window.location = '/admin/carpark';
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop
