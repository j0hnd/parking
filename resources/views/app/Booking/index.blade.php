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
                                <th>Reservation Name</th>
                                <th>Drop Off</th>
                                <th>Return At</th>
                                <th>Date Posted</th>
                                <th></th>
                            </tr>
                            @if(count($bookings))
                                @foreach($bookings as $booking)

                                    @php
                                        $drop_off = new \Carbon\Carbon($booking->drop_off_at);
										$return_at = new \Carbon\Carbon($booking->return_at);

										$no_of_days = $return_at->diffInDays($drop_off);

										if ($no_of_days == 1) {
											$no_of_days = 1;
										} else {
											$no_of_days = $no_of_days + 1;
										}

										$order_title = $booking->products[0]->airport[0]->airport_name.' - '.$booking->products[0]->carpark->name.' - '.$booking->products[0]->prices[0]->categories->category_name.' [No. of days: '.$no_of_days.' - £'.$booking->price_value.']';
                                    @endphp

                                <tr>
                                    <td><a href="{{ url('/admin/booking/'.$booking->id.'/edit') }}">{{ $booking->booking_id }}</a></td>
                                    <td>{{ $order_title }}</td>
                                    <td>{{ $booking->customers->first_name }} {{ $booking->customers->last_name }}</td>
                                    @if(empty($booking->client_first_name) and empty($booking->client_last_name))
                                    <td>N/A</td>
                                    @else
                                    <td>{{ $booking->client_first_name }} {{ $booking->client_last_name }}</td>
                                    @endif
                                    <td>{{ $booking->drop_off_at->format('d/m/Y') }}</td>
                                    <td>{{ $booking->return_at->format('d/m/Y') }}</td>
                                    <td>{{ $booking->created_at->format('d/m/Y') }}</td>
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
