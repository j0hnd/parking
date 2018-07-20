@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Fill up User Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="airport-form" class="form-horizontal" method="post" action="{{ url('/admin/users/update') }}">
                    @include('app.User.partials._form')

                    <div class="box-footer">
                        <a href="{{ url('/admin/users') }}" class="btn btn-default pull-right margin-left5" >Cancel</a>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Update</button>
                    </div>
                    <!-- /.box-footer -->

                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $user_info->id }}">
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('#role-id').select2({ placeholder: '-- Roles --' });
            $('#company-name').select2({ placeholder: '-- Company --' });

            $(document).on('change', '#role-id', function (e) {
                if ($(this).val() == 2 ) {
                    $('#company-info-wrapper').removeClass('hidden');
                    $('#carpark-wrapper').removeClass('hidden');
                    $('#company-wrapper').addClass('hidden');
                    setTimeout(function () {
                        $('#company-name').select2({
                            placeholder: '-- Company --',
                            tags: true
                        });
                    }), 300;
                } else if ($(this).val() == 3) {
                    $('#company-info-wrapper').removeClass('hidden');
                    $('#company-wrapper').removeClass('hidden');
                    $('#carpark-wrapper').addClass('hidden');
                    setTimeout(function () {
                        $('#company-name').select2({
                            placeholder: '-- Company --',
                            tags: true
                        });
                    }), 300;
                } else {
                    $('#company-info-wrapper').addClass('hidden');
                }
            });

            $(document).on('change', '#company-name', function () {
                $.ajax({
                    url: "{{ url('/admin/carpark/info') }}/" + $(this).val(),
                    type: 'get',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            var address = response.data.address+" "+response.data.city+", "+response.data.county_state+" "+response.data.zipcode;
                            $('#address').val(address);
                        }
                    }
                });
            });
        });
    </script>
@stop
