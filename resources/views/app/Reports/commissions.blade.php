@extends('admin_template')

@section('styles')
<style type="text/css">
    #summary td {
        font-size: 18px;
    }

    .drop-off {
        color: #0000ee;
    }

    .return-at {
        color: #002a80;
    }
</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'commissions', 'generate_url' => url('/admin/reports/commissions')])

    @include('app.Reports.partials._more')

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                @php
                    $total_cost_after = $total_cost = 0;
                @endphp

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="text-center">Order Number</th>
                        <th class="text-center">Vendor's Name</th>
                        <th class="text-center">Commission %</th>
                        <th class="text-right">Total Order Value</th>
                        <th class="text-right">Car Parking Product Value</th>
                        <th class="text-right">Revenue Share</th>
                        <th class="text-right">Booking Fee</th>
                        <th class="text-right">SMS Confirmation Fee</th>
                        <th class="text-right">Cancellation Waiver</th>
                        <th class="text-right">Affiliate Cost %</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($bookings))
                        @php
                            $total_order_value   = 0;
                            $total_revenue_share = 0;
                            $total_price_value   = 0;
                            $total_booking_fee   = 0;
                            $total_sms_confirmation_fee = 0;
                            $total_cancellation_waiver  = 0;
                            $total_affiliate_cost       = 0;
                            $grand_total                = 0;
                        @endphp

                        @foreach($bookings as $booking)
                            @php
                                $order_value = $booking->price_value + $booking->booking_fees + $booking->sms_confirmation_fee + $booking->cancellation_wavier;
                                $total_order_value += $order_value;

                                $revenue_share = number_format($booking->price_value * ($booking->products[0]->revenue_share/100), 2);
                                $total_revenue_share += $revenue_share;

                                if (isset($booking->affiliate_bookings[0])) {
                                    $affiliate_percent = round($booking->affiliate_bookings[0]->affiliates[0]->percent_travel_agent / 100, 2);
                                    $affiliate_cost = round($revenue_share * $affiliate_percent, 2);
                                    $total_affiliate_cost += $affiliate_cost;
                                } else {
                                    $affiliate_cost = 0;
                                }

                                $total_price_value += $booking->price_value;
                                $total_booking_fee += $booking->booking_fees;
                                $total_sms_confirmation_fee += $booking->sms_confirmation_fee;
                                $total_cancellation_waiver += $booking->cancellation_waiver;
                            @endphp

                        <tr id="booking-{{ $booking->id }}">
                            <td class="text-center"><a href="{{ url('/admin/booking/'.$booking->id.'/edit') }}" target="_blank">{{ $booking->booking_id }}</a></td>
                            <td class="text-center ">{{ $booking->products[0]->carpark->name }}</td>
                            <td class="text-center">{{ $booking->products[0]->revenue_share }}%</td>
                            <td class="text-right">£{{ $order_value }}</td>
                            <td class="text-right">£{{ $booking->price_value }}</td>
                            <td class="text-right">£{{ $revenue_share }}</td>
                            <td class="text-right">£{{ $booking->booking_fees }}</td>
                            <td class="text-right">£{{ $booking->sms_confirmation_fee }}</td>
                            <td class="text-right">£{{ $booking->cancellation_waiver }}</td>
                            <td class="text-right">£{{ $affiliate_cost }}</td>
                        </tr>
                        @endforeach
                        <tr id="summary" class="bg-aqua">
                            <td colspan="3">Total</td>
                            <td class="text-right"><strong>£{{ $total_order_value }}</strong></td>
                            <td class="text-right"><strong>£{{ $total_price_value }}</strong></td>
                            <td class="text-right"><strong>£{{ $total_revenue_share }}</strong></td>
                            <td class="text-right"><strong>£{{ $total_booking_fee }}</strong></td>
                            <td class="text-right"><strong>£{{ $total_sms_confirmation_fee }}</strong></td>
                            <td class="text-right"><strong>£{{ $total_cancellation_waiver }}</strong></td>
                            <td class="text-right"><strong>£{{ $total_affiliate_cost }}</strong></td>
                        </tr>
                        @php
                            // $grand_total = $total_booking_fee + $total_sms_confirmation_fee + $total_cancellation_waiver + $total_affiliate_cost;
                            $grand_total = $total_revenue_share + $total_booking_fee + $total_sms_confirmation_fee + $total_cancellation_waiver;
                        @endphp
                        <tr id="grand-total" class="bg-yellow">
                            <td colspan="8"></td>
                            <td class="text-right">Grand Total: </td>
                            <td class="text-center"><strong><span style="font-size: 22px;">£{{ $grand_total }}</span></strong></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="10" class="text-center"><strong>No data found</strong></td>
                        </tr>
                    @endif
                    </tbody>

                    @if($bookings instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <tfoot>
                        <tr>
                            <td colspan="10" class="text-right">{!! $bookings->appends(Request::except(['page', '_token'])) ->links()!!}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script src="{{ url('js/reports.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(function () {
        var selected_date = '{{ $selected_date }}';
        setTimeout(function () {
            if (selected_date) {
                $("#reportrange span").html(selected_date);
            }
        }, 300);

        $(document).on('change', '#per-page-src', function (e) {
            $('#per-page').val($(this).val());
            $('#report-form').submit();
        });
    });
</script>
@stop
