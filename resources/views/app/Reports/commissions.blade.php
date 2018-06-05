@extends('admin_template')

@section('main-content')
	@include('app.Reports.partials._filters')
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
        console.log(date_value);
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