@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $new_bookings }}</h3>

                    <p>New Bookings</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $total_bookings }}</h3>

                    <p>Total Bookings</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>£{{ number_format($revenue->revenue, 2) }}</h3>

                    <p>Revenue as of {{ date('F jS') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $completed_jobs }}</h3>

                    <p>Completed Jobs as of {{ date('F jS') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Monthly Summary</h3>
                </div>

                <div class="box-body no-padding">
                    @php
                        $total_sales = 0;
						$total_revenue = 0;
						$total_revenue_percent = 0;
                    @endphp
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <th>Month</th>
                            <th class="text-right">Sales</th>
                            <th class="text-right">Revenue</th>
                            <th class="text-center">Revenue (%)</th>
                        </tr>

                        @if($summary)
                            @foreach($summary as $_summary)
                                <tr>
                                    <td>{{ $_summary->MONTH }}</td>
                                    <td class="text-right">£{{ number_format($_summary->sales, 2) }}</td>
                                    <td class="text-right">£{{ number_format($_summary->revenue, 2) }}</td>
                                    <td class="text-center">{{ number_format(($_summary->sales/$_summary->revenue), 2) }}%</td>
                                </tr>

                                @php
                                    $total_sales += $_summary->sales;
                                    $total_revenue += $_summary->revenue;
                                    $total_revenue_percent += ($_summary->sales/$_summary->revenue);
                                @endphp

                            @endforeach
                        @endif
                        </tbody>
                        <tfoot>
                        <tr class="bg-aqua">
                            <td>&nbsp;</td>
                            <td class="text-right">£{{ number_format($total_sales, 2) }}</td>
                            <td class="text-right">£{{ number_format($total_revenue, 2) }}</td>
                            <td class="text-center">{{ number_format($total_revenue_percent, 2) }}%</td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>Monthly Revenue</h3>
                </div>
                <div class="box-body">
                    <canvas id="myChart" class="col-md-12" height="90px"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script type="text/javascript" src="{{ asset('/bower_components/chart.js/Chart.min.js') }}"></script>
<script type="text/javascript">
    var chartData = {
        labels : <?php echo $area_months ?>,
        datasets : [
            {
                fillColor : "rgba(172,194,132,0.4)",
                strokeColor : "#ACC26D",
                pointColor : "#fff",
                pointStrokeColor : "#9DB86D",
                data : <?php echo $area_data ?>
            }
        ]
    }

    // get line chart canvas
    var chart = document.getElementById('myChart').getContext('2d');

    // draw line chart
    new Chart(chart).Line(chartData);
</script>
@stop
