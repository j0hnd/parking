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
                        <thead>
                            <tr>
                                <th>Carpark Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>County/State</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="carparks-container">
                            @include('app.Carpark.partials._list')
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

            $(document).on('click', '.toggle-carpark', function () {
                var _status = $(this).data('status');
                var _id = $(this).data('id');

                if (_status == 'deactivate') {
                    swal({
                        title: "Carparks",
                        text: "Deactivate this carpark?",
                        type: 'warning',
                        showCancelButton: true
                    }).then(function (response) {
                        if (response.value == true) {
                            toggleCarpark(_id, _status);
                        }
                    });
                }

                if (_status == 'activate') {
                    toggleCarpark(_id, _status);
                }
            });

            function toggleCarpark(id, status) {
                var _data= {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                };

                $.ajax({
                    url: "{{ url('/admin/carpark/toggle') }}",
                    type: "post",
                    data: _data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status) {
                            swal({
                                title: "Carparks",
                                text: response.message,
                                type: 'success'
                            });

                            $('#carparks-container').html(response.data.html)
                        } else {
                            swal({
                                title: "Carparks",
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
