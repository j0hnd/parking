<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use App\Models\Products;
use App\Models\Tools\Common;
use App\Models\Tools\Fees;
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
    	$form = null;

        if ($request->isMethod('post')) {
			$form = $request->except(['_token']);
			$products = Products::search($form);
			$results = Products::prepare_data($products);
			$drop_off_time = $form['search']['drop-off-time'];
			$return_at_time = $form['search']['return-at-time'];
        } else {
        	$drop_off_time = "";
        	$return_at_time = "";
		}



        $airports = Airports::active()->get();
        $drop_off_time_interval  = Common::get_times(date('H:i'), '+5 minutes', $drop_off_time);
        $return_at_time_interval = Common::get_times(date('H:i'), '+5 minutes', $return_at_time);

        return view('parking.search', compact('airports', 'drop_off_time_interval', 'return_at_time_interval', 'results', 'form'));
    }

    public function payment(Request $request)
	{
		try {
			if ($request->isMethod('post')) {
				$form = $request->only(['products', 'drop_off', 'return_at']);

				list($index, $product_id, $airport_id, $price_id, $price_value) = explode(':', $form['products']);
				list($drop_off_date, $drop_off_time) = explode(" ", $form['drop_off']);
				list($return_at_date, $return_at_time) = explode(" ", $form['return_at']);

				$airport = Airports::findOrFail($airport_id);
				$product = Products::findOrFail($product_id);
				$price   = Prices::findOrFail($price_id);

				$booking_fee          = Fees::active()->where('fee_name', 'booking_fee')->first();
				$sms_confirmation_fee = Fees::active()->where('fee_name', 'sms_confirmation_fee')->first();
				$cancellation_waiver  = Fees::active()->where('fee_name', 'cancellation_waiver')->first();

				session('products', $form['products']);

				return view('parking.payment', compact(
					'product',
					'airport',
					'price',
					'price_value',
					'booking_fee',
					'sms_confirmation_fee',
					'cancellation_waiver',
					'drop_off_date',
					'drop_off_time',
					'return_at_date',
					'return_at_time'
				));
			}
		} catch (\Exception $e) {
			dd($e);
		}

		return redirect('/');
	}
}
