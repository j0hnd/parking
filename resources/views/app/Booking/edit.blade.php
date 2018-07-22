@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info">
                <form id="airport-form" class="form-horizontal" method="post" action="{{ url('/admin/booking/update') }}">
                    <div class="box-body">
                        @include('common.flash')

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

                        <input type="hidden" name="order_title_str" id="order-title-str" value="{{ $booking->order_title }}">
                        <input type="hidden" name="id" value={{ $booking->id }}>
                        <input type="hidden" name="customer_id" value={{ $booking->customer_id }}>
                    </div>

                    <div class="box-footer">
                        <a href="{{ url('/admin/booking') }}" class="btn btn-default pull-right margin-left5" >Cancel</a>
                        <button type="submit" id="toggle-save" class="btn btn-info pull-right">Update</button>
                    </div>
                </form>
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
            url: '{{ url('/admin/customer/search') }}',
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
        var ref = $(this).val().split(';');
        var revenue_value = 0;
        $('#order-title-str').val($("#order-title option:selected").text());
        $.ajax({
            url: '{{ url('/admin/get/price') }}',
            data: { product_id: ref[0], price_id: ref[1] },
            dataType: 'json',
            success: function (response) {
                if (response) {
                    $('#price-value').val(response.price_value);
                    $('#departure-terminal')
                        .empty()
                        .append(response.terminals);
                    $('#arrival-terminal')
                        .empty()
                        .append(response.terminals);
                    revenue_value = parseFloat(response.price_value * (response.revenue_share / 100)).toFixed(2);
                } else {
                    $('#price-value').val(0);
                }

                if ($('#revenue-share').is(':visible')) {
                    $('#revenue-share').val(revenue_value);
                }
            }
        });
    });

    $(document).on('change', '#vehicle-make', function () {
        var index = $("#vehicle-make option:selected").data('index');
        var make = $(this).val();

        $.ajax({
            url: '{{ url('/admin/get/vehicle/model') }}',
            data: { make: make, index: index },
            dataType: 'json',
            success: function (response) {
                $('#vehicle-model')
                    .empty()
                    .append(response.options);
            }
        });
    });

    $(document).on('change', '#vehicle-make', function () {
        $('#vehicle-model').removeClass('hidden');
        $('#other-vehicle-model').val('');
        $('#other-vehicle-model').addClass('hidden');
    });

    $(document).on('change', '#vehicle-model', function () {
        var txt = $("#vehicle-model option:selected").text();
        if (txt.indexOf('Other') != -1) {
            $(this).addClass('hidden');
            $('#other-vehicle-model').removeClass('hidden');
            $('#other-vehicle-model').focus();
        } else {
            $(this).removeClass('hidden');
            $('#other-vehicle-model').addClass('hidden');
        }
    });

    $(document).on('change', '#price-value', function () {
        var orderID = $('#order-title').val().split(';');

        $.ajax({
            url: '{{ url('/autocomplete/product/revenue/share/') }}' + '/' + orderID[0],
            type: 'post',
            data: { price: $(this).val(), _token: '{{ csrf_token() }}' },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#revenue-share').prop('readonly', false);
                    $('#revenue-share').val(response.data);
                    $('#revenue-share').prop('readonly', true);
                } else {
                    $('revenue-share').val('0.00');
                }
            }
        });
    });


    $("#order-title").select2({
        placeholder: '-- Order Title --'
    });

    $("#search-customer").select2({
        placeholder: '-- Customer --'
    });

    $("#vehicle-make").select2({
        placeholder: '-- Vehicle Make --'
    });

    $("#departure-terminal").select2({
        placeholder: '-- Departure Terminal --',
        tags: true
    });

    $("#arrival-terminal").select2({
        placeholder: '-- Arrival Terminal --',
        tags: true
    });

    $('#drop-off-date').datepicker({
        autoclose: true
    })

    $('#drop-off-time').timepicker();
    $('#return-at-time').timepicker();

    $('#return-at-date').datepicker({
        autoclose: true
    })

    $('#departure-terminal')
        .empty()
        .append("{!! html_entity_decode($terminal_options) !!}");
    $('#arrival-terminal')
        .empty()
        .append("{!! html_entity_decode($terminal_options) !!}");
});
</script>
@stop
