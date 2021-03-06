<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use App\Models\Products;
use App\Models\Tools\Common;
use Illuminate\Http\Request;

class ParkingAppController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $airports = Airports::active()->get();
        $time_intervals = Common::get_times(date('H:i'), '+5 minutes');
        return view('parking.index', compact('airports', 'time_intervals'));
    }

    public function search(Request $request)
    {
        if ($request->isMethod('post')) {
             $form = $request->except(['_token']);
             $products = Products::search($form);
             $results = Products::prepare_data($products);
        }

        $airports = Airports::active()->get();
        $time_intervals = Common::get_times(date('H:i'), '+5 minutes');

        return view('parking.search', compact('airports', 'time_intervals', 'results'));
    }

    public function payment()
	{
		return view('parking.payment');
	}
}
