<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use App\Models\Products;
use App\Models\Tools\Common;
use App\Models\Tools\Prices;
use Carbon\Carbon;
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

    public function payment(Request $request)
	{
		if ($request->isMethod('post')) {
			$form = $request->only(['products', 'drop_off', 'return_at']);

			list($index, $product_id, $price_id, $price_value) = explode(':', $form['products']);
			list($drop_off_date, $drop_off_time) = explode(" ", $form['drop_off']);
			list($return_at_date, $return_at_time) = explode(" ", $form['return_at']);

			$product = Products::findOrFail($product_id);
			$price = Prices::findOrFail($price_id);
			$booking_fee = 0;

			session('products', $form['products']);

			return view('parking.payment', compact(
				'product',
				'price',
				'booking_fee',
				'price_value',
				'drop_off_date',
				'drop_off_time',
				'return_at_date',
				'return_at_time'
			));
		}

		return redirect('/');
	}
}
