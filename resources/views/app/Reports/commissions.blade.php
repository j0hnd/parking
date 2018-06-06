@extends('admin_template')

@section('main-content')
	@include('app.Reports.partials._filters')

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Vendor</th>
                        <th>Airport/Parking Type</th>
                        <th class="text-center">Revenue Share</th>
                        <th class="text-center">Revenue Value</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($bookings))
                        @foreach($bookings as $booking)
                        <tr id="booking-{{ $booking->id }}">
                            <td>{{ $booking->booking_id }}</td>
                            <td>{{ $booking->products[0]->vendors[0]->company_name }}</td>
                            <td>{{ $booking->order_title }}</td>
                            <td class="text-center">{{ $booking->products[0]->revenue_share }}%</td>
                            <td class="text-center">£{{ $booking->revenue_value }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center bg-red">No data found</td>
                        </tr>
                    @endif
                    </tbody>

                    @if(count($bookings))
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right">{{ $bookings->links() }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript">
$(function () {
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        var date_value = picker.startDate.format('Y-m-d')+':'+picker.endDate.format('Y-m-d');
        $('#date').val(date_value);
    });

    cb(start, end);

    var _date = $('#reportrange').text().trim();
    _date = _date.split(' - ');
    var startDate = moment(_date[0]).format('YYYY-MM-DD');
    var endDate = moment(_date[1]).format('YYYY-MM-DD');

    $('#date').val(startDate+':'+endDate);
});
</script>
@stop