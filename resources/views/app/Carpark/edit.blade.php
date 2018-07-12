@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')

            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Fill up Carpark Details</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form id="carpark-form" class="form-horizontal" method="post" action="{{ url('/admin/carpark/update') }}" enctype="multipart/form-data">
                    @include('app.Carpark.partials._form', compact('carpark'))

                    <div class="box-footer">
                        <button type="button" class="btn btn-default pull-right toggle-cancel" data-back="{{ url('/admin/carpark') }}" style="margin-left: 7px;">Cancel</button>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Update</button>
                    </div>
                    <!-- /.box-footer -->

                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $carpark->id }}">
                </form>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function(){
            $('#countries').select2({ placeholder: '-- Country --' });

            $(document).on('change', '#is-24hr', function () {
                if ($(this).is(':checked')) {
                    $('#custom-time-wrapper').addClass('hidden');
                    $('#opening').val('');
                    $('#closing').val('');
                } else {
                    $('#custom-time-wrapper').removeClass('hidden');
                }
            });
        });
    </script>
@stop
