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

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                @php
                    $total_cost_after = $total_cost = 0;
                @endphp

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Vendor</th>
                        <th>Airport/Parking Type</th>
                        <th class="text-left">Customer Name</th>
                        <th class="text-center">Book Date</th>
                        <th class="text-center">Drop of Date/Return Date</th>
                        <th class="text-right">Cost</th>
                        <th class="text-right">Cost after Affiliate %</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($bookings))
                        @foreach($bookings as $booking)
                            @php
                                $cost_after = $cost = 0;
                            @endphp
                        <tr id="booking-{{ $booking->id }}">
                            <td><a href="{{ url('/admin/booking/'.$booking->id.'/edit') }}" target="_blank">{{ $booking->booking_id }}</a></td>
                            <td>{{ $booking->products[0]->vendors[0]->company_name }}</td>
                            <td>{{ $booking->order_title }}</td>
                            <td class="text-left">{{ $booking->customers->first_name }}&nbsp;{{ $booking->customers->last_name }}</td>
                            <td class="text-center">{{ $booking->created_at->format('F j, Y') }}</td>
                            <td class="text-center"><span class="drop-off">{{ $booking->drop_off_at->format('F j, Y') }}</span>/<span class="return-at">{{ $booking->return_at->format('F j, Y') }}</span></td>
                            <td class="text-right">
                                @php
                                    $cost = ($booking->price_value + $booking->booking_fee + $booking->sms_confirmation_fee + $booking->cancellation_waiver) - $booking->revenue_value;
                                    $total_cost += $cost;
                                @endphp
                                £{{ number_format($cost, 2) }}
                            </td>
                            <td class="text-right">
                                @php
                                    $percent_admin = "";

                                    if (isset($booking->affiliate_bookings[0]->affiliates)) {
                                        $percent_admin = $booking->affiliate_bookings[0]->affiliates[0]->percent_admin;
                                        $cost_after = number_format($cost * round(($percent_admin / 100), PHP_ROUND_HALF_UP), 2);
                                        $total_cost_after += $cost_after;
                                    }
                                @endphp
                                £{{ $cost_after }}
                                @if(!empty($percent_admin))<sup>({{ $percent_admin }}%)</sup>@endif
                            </td>
                        </tr>
                        @endforeach
                        <tr id="summary" class="bg-aqua">
                            <td colspan="6"></td>
                            <td class="text-right"><strong>£{{ number_format($total_cost, 2) }}</strong></td>
                            <td class="text-right"><strong>£{{ number_format($total_cost_after, 2) }}</strong></td>
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