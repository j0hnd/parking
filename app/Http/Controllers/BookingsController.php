<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Products;
use App\Models\Customers;
use App\Http\Requests\BookingFormRequest;

class BookingsController extends Controller
{
    public function index()
    {
        $page_title = "Bookings List";
        $bookings = Bookings::active()->orderBy('created_at', 'desc')->paginate(15);
        return view('app.Booking.index', compact('page_title', 'bookings'));
    }

    public function create()
    {
        $page_title = "Create Booking";
        $products   = Products::active()->orderBy('created_at', 'desc');
        $customers  = Customers::active()->orderBy('last_name', 'asc');
        return view('app.Booking.create', compact('page_title', 'products', 'customers'));
    }
}
