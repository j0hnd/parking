@extends('admin_template')
@section('main-content')
    <div class="row">
        <div class="col-xs-12">
            @include('common.flash')
            <div class="box">
                <div class="box-header">
                    <a href="{{ url('/admin/booking/create') }}" class="btn bg-navy btn-flat">Add Booking</a>

                    <div class="box-tools" style="margin-top: 7px">
                        <form action="{{ url('/admin/booking/search') }}" method="post">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control pull-right" placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>Booking ID</th>
                                <th>Order Title</th>
                                <th>Customer</th>
                                <th>Booking Date</th>
                                <th></th>
                            </tr>
                            @if(count($bookings))
                                @foreach($booking as $booking)
                                <tr>
                                    <td>{{ $booking->booking_id }}</td>
                                    <td>{{ $booking->order_title }}</td>
                                    <td>{{ $booking->customer_first_name }} {{ $booking->custome_last_name }}</td>
                                    <td>{{ $booking->booking_date->format('m/d/Y') }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No bookings listed</td>
                                </tr>
                            @endif
                        </tbody>
                        @if(count($bookings))
                        <tfoot>
                            <tr>
                                <td colspan="5">{{ $bookings->links() }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
