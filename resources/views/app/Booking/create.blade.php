@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <div class="box-body">
                    @include('common.flash')

                    <form id="airport-form" class="form-horizontal" method="post" action="{{ url('/admin/booking') }}">
                        <div class="col-xs-6">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fill up Booking Information</h3>
                            </div>

                            <!-- form start -->
                            @include('app.Booking.partials._form_booking')
                        </div>

                        <div class="col-xs-6">
                            <div class="box-header with-border">
                                <h3 class="box-title">Fill up Customer Information</h3>
                            </div>

                            <div class="box-body">
                                <!-- form start -->
                                @include('app.Booking.partials._form_customer')
                            </div>
                        </div>

                        {{ csrf_field() }}
                    </form>
                </div>

                <div class="box-footer">
                    <button type="button" class="btn btn-default pull-right" style="margin-left: 7px;">Cancel</button>
                    <button type="submit" id="toggle-save" class="btn btn-info pull-right">Save</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
$(function () {
    $(document).on('click', '#toggle-new-customer', function (e) {
        $('.new-customer-container').removeClass('hidden');
        $('.search-container').addClass('hidden');
    });

    $(document).on('click', '#toggle-show-search', function (e) {
        $('.new-customer-container').addClass('hidden');
        $('.search-container').removeClass('hidden');
    });
});
</script>
@stop
