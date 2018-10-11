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
                        <thead>
                            <tr>
                                <th>Airport Name</th>
                                <th>City</th>
                                <th>County/State</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="airports-container">
                            @include('app.Airport.partials._list')
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

    $(document).on('click', '.toggle-airport', function () {
        var _status = $(this).data('status');
        var _id = $(this).data('id');

        if (_status == 'deactivate') {
            swal({
                title: "Airports",
                text: "Deactivate this airport?",
                type: 'warning',
                showCancelButton: true
            }).then(function (response) {
                if (response.value == true) {
                    toggleAirport(_id, _status);
                }
            });
        }

        if (_status == 'activate') {
            toggleAirport(_id, _status);
        }
    });

    function toggleAirport(id, status) {
        var _data= {
            _token: "{{ csrf_token() }}",
            id: id,
            status: status
        };

        $.ajax({
            url: "{{ url('/admin/airport/toggle') }}",
            type: "post",
            data: _data,
            dataType: 'json',
            success: function (response) {
                if (response.status) {
                    swal({
                        title: "Airports",
                        text: response.message,
                        type: 'success'
                    });

                    $('#airports-container').html(response.data.html)
                } else {
                    swal({
                        title: "Airports",
                        text: response.message,
                        type: 'error'
                    });
                }
            }
        });
    }
});
</script>
@stop