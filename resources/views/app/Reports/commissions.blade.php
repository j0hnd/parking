@extends('admin_template')

@section('styles')
<style type="text/css">
    #summary td {
        font-size: 18px;
    }
</style>
@stop

@section('main-content')
	@include('app.Reports.partials._filters', ['export' => 'commissions', 'generate_url' => url('/admin/reports/commissions')])

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                @php
                    $total_booking_fee = 0;
					$total_sms = 0;
					$total_cancellation = 0;
					$total_share = 0;
					$total_revenue = 0;
                @endphp

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Vendor</th>
                        <th>Airport/Parking Type</th>
                        <th class="text-right">Booking Fee</th>
                        <th class="text-right">SMS Confirmation Fee</th>
                        <th class="text-right">Cancellation Waiver</th>
                        <th class="text-center">Revenue Share</th>
                        <th class="text-right">Revenue Value</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($bookings))
                        @foreach($bookings as $booking)

                            @php
                                $total_booking_fee += $booking->booking_fees;
                                $total_sms += $booking->sms_confirmation_fee;
                                $total_cancellation += $booking->cancellation_waiver;
                                $total_revenue += $booking->revenue_value;
                            @endphp

                        <tr id="booking-{{ $booking->id }}">
                            <td><a href="{{ url('/admin/booking/'.$booking->id.'/edit') }}">{{ $booking->booking_id }}</a></td>
                            <td>{{ $booking->products[0]->vendors[0]->company_name }}</td>
                            <td>{{ $booking->order_title }}</td>
                            <td class="text-right">£{{ number_format($booking->booking_fees, 2) }}</td>
                            <td class="text-right">{{ is_null($booking->sms_confirmation_fee) ? 0  : "£".number_format($booking->sms_confirmation_fee, 2)}}</td>
                            <td class="text-right">{{ is_null($booking->cancellation_waiver) ? 0  : "£".number_format($booking->cancellation_waiver, 2)}}</td>
                            <td class="text-center">{{ $booking->products[0]->revenue_share }}%</td>
                            <td class="text-right">£{{ $booking->revenue_value + $booking->booking_fees + (is_null($booking->sms_confirmation_fee) ? 0 : $booking->sms_confirmation_fee) + (is_null($booking->cancellation_waiver) ? 0 : $booking->cancellation_waiver) }}</td>
                        </tr>
                        @endforeach
                        <tr id="summary" class="bg-aqua">
                            <td colspan="3"></td>
                            <td class="text-right"><strong>£{{ number_format($total_booking_fee, 2) }}</strong></td>
                            <td class="text-right"><strong>£{{ number_format($total_sms, 2) }}</strong></td>
                            <td class="text-right"><strong>£{{ number_format($total_cancellation, 2) }}</strong></td>
                            <td class="text-center"></td>
                            <td class="text-right"><strong>£{{ number_format($total_revenue, 2) }}</strong></td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="8" class="text-center"><strong>No data found</strong></td>
                        </tr>
                    @endif
                    </tbody>

                    @if(count($bookings))
                    <tfoot>
                        <tr>
                            <td colspan="8" class="text-right">{{ $bookings->links() }}</td>
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
    });
</script>
@stop