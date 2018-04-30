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

                                <input type="hidden" name="customer_id" id="customer-id">
                            </div>
                        </div>

                        {{ csrf_field() }}

                        <div class="box-footer">
                            <button type="button" class="btn btn-default pull-right" style="margin-left: 7px;">Cancel</button>
                            <button type="submit" id="toggle-save" class="btn btn-info pull-right">Save</button>
                        </div>

                        <input type="hidden" name="order_title_str" id="order-title-str">
                    </form>
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

    $(document).on('change', '#search-customer', function (e) {
        var custID = $(this).val();
        $.ajax({
            url: '/admin/customer/search',
            data: { id: custID },
            dataType: 'json',
            success: function (response) {
                $('.new-customer-container').removeClass('hidden');
                $('.search-container').addClass('hidden');

                $('#customer-id').val(response.id);
                $('#first-name').val(response.first_name);
                $('#last-name').val(response.first_name);
                $('#email').val(response.email);
                $('#mobile-no').val(response.mobile_no);
            }
        });
    });

    $(document).on('change', '#order-title', function () {
        $('#order-title-str').val($("#order-title option:selected").text());
    });

    $("#order-title").select2({
        placeholder: '-- Order Title --'
    });

    $("#search-customer").select2({
        placeholder: '-- Customer --'
    });

    $('#drop-off-at').datepicker({
        autoclose: true
    })

    $('#return-at').datepicker({
        autoclose: true
    })
});
</script>
@stop