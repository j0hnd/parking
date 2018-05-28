<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Products;
use App\Models\Tools\Common;
use App\Models\Tools\Fees;
use App\Models\Tools\Prices;
use App\Models\Tools\Sessions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Srmklive\PayPal\Facades\PayPal;
use DB;

class ParkingAppController extends Controller
{
	private $provider;


    public function __construct()
    {
        $this->middleware('guest');
		$this->provider = PayPal::setProvider('express_checkout');
		$this->provider->setApiCredentials(config('paypal'));
    }

    public function index()
    {
        $airports = Airports::active()->get();
		$drop_off_time_interval = Common::get_times(date('H:i'), '+5 minutes');
		$return_at_time_interval = Common::get_times(date('H:i'), '+5 minutes');
        return view('parking.index', compact('airports', 'drop_off_time_interval', 'return_at_time_interval'));
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
		if ($request->isMethod('post') || isset($request->token)) {
			$form = $request->only(['products', 'drop_off', 'return_at']);


			// Sessions::active()->orderBy('created_at', 'desc')->first();
			// $cache_key = 'request.'.$request->session()->getId();

			if (Cache::has('booking')) {
				$form = Cache::get('booking');
			} else {
				Cache::put('booking', $form);
			}

			 dd(Cache::has('booking'));

			list($index, $product_id, $airport_id, $price_id, $price_value) = explode(':', $form['products']);
			list($drop_off_date, $drop_off_time) = explode(" ", $form['drop_off']);
			list($return_at_date, $return_at_time) = explode(" ", $form['return_at']);

			$airport = Airports::findOrFail($airport_id);
			$product = Products::findOrFail($product_id);
			$price   = Prices::findOrFail($price_id);

			$booking_fee          = Fees::active()->where('fee_name', 'booking_fee')->first();
			$sms_confirmation_fee = Fees::active()->where('fee_name', 'sms_confirmation_fee')->first();
			$cancellation_waiver  = Fees::active()->where('fee_name', 'cancellation_waiver')->first();

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
	}

	public function payment_success(Request $request)
	{
		$paypal_response = $request->all();

		if (empty($paypal_response)) {
			abort(502);
		}

		if (isset($paypal_response['token'])) {
			$response = $this->provider->getExpressCheckoutDetails($paypal_response['token']);
			if ($response['ACK'] == 'Success') {
				if ($request->session()->has('bookings')) {
					$booking_data = session('bookings');
					list($product_id, $price_id) = explode(':', $booking_data['ids']);

					DB::beginTransaction();

					// save customer information
					$customer['first_name'] = $booking_data['firstname'];
					$customer['last_name'] = $booking_data['lastname'];
					$customer['email'] = $booking_data['email'];
					$customer['mobile_no'] = $booking_data['phoneno'];
					$customer = Customers::create($customer);

					// save booking data
					$products = Products::findOrFail($product_id);
					$revenue_value = number_format(($booking_data['total'] * 1) * ($products->revenue_share / 100), 2);

					$bookings['order_title'] = $booking_data['product'];
					$bookings['customer_id'] = $customer->id;
					$bookings['product_id'] =  $product_id;
					$bookings['price_id'] = $price_id;
					$bookings['price_value'] = $booking_data['total'];
					$bookings['revenue_value'] = $revenue_value;
					$bookings['sms_confirmation_fee'] = $booking_data['sms'];
					$bookings['cancellation_fee'] = $booking_data['cancellation'];
					$bookings['drop_off_at'] = Carbon::now();
					$bookings['return_at'] = Carbon::now();

					$booking = Bookings::create($bookings);
					if (!empty($booking)) {
						Bookings::findOrFail($booking->id)->update(['booking_id' => Bookings::generate_booking_id($booking->id)]);
						DB::commit();
						session('bid', $booking->id);

						return redirect('/payment/' . Hash::make($paypal_response['token']));
					} else {
						DB::rollback();
						dd('1');
					}
				}
			}
		} else {
			abort(502);
		}
	}

//    public function payment(Request $request)
//	{
//		try {
//			if ($request->isMethod('post')) {
//				$form = $request->only(['products', 'drop_off', 'return_at']);
//
//				list($index, $product_id, $airport_id, $price_id, $price_value) = explode(':', $form['products']);
//				list($drop_off_date, $drop_off_time) = explode(" ", $form['drop_off']);
//				list($return_at_date, $return_at_time) = explode(" ", $form['return_at']);
//
//				$airport = Airports::findOrFail($airport_id);
//				$product = Products::findOrFail($product_id);
//				$price   = Prices::findOrFail($price_id);
//
//				$booking_fee          = Fees::active()->where('fee_name', 'booking_fee')->first();
//				$sms_confirmation_fee = Fees::active()->where('fee_name', 'sms_confirmation_fee')->first();
//				$cancellation_waiver  = Fees::active()->where('fee_name', 'cancellation_waiver')->first();
//
//				return view('parking.payment', compact(
//					'product',
//					'airport',
//					'price',
//					'price_value',
//					'booking_fee',
//					'sms_confirmation_fee',
//					'cancellation_waiver',
//					'drop_off_date',
//					'drop_off_time',
//					'return_at_date',
//					'return_at_time'
//				));
//			} else {
//				$paypal_response = $request->all();
//				if (isset($paypal_response['token'])) {
//					$response = $this->provider->getExpressCheckoutDetails($paypal_response['token']);
//					if ($response['ACK'] == 'Success') {
//
//						// TODO: create bookings
//						if ($request->session()->has('bookings')) {
//							$booking_data = session('bookings');
//							list($product_id, $price_id) = explode(':', $booking_data['ids']);
//
//							DB::beginTransaction();
//
//							// save customer information
//							$customer['first_name'] = $booking_data['firstname'];
//							$customer['last_name'] = $booking_data['lastname'];
//							$customer['email'] = $booking_data['email'];
//							$customer['mobile_no'] = $booking_data['phoneno'];
//							$customer = Customers::create($customer);
//
//							// save booking data
//							$products = Products::findOrFail($product_id);
//							$revenue_value = number_format(($booking_data['total'] * 1) * ($products->revenue_share / 100), 2);
//
//							$bookings['order_title'] = $booking_data['product'];
//							$bookings['customer_id'] = $customer->id;
//							$bookings['product_id'] =  $product_id;
//							$bookings['price_id'] = $price_id;
//							$bookings['price_value'] = $booking_data['total'];
//							$bookings['revenue_value'] = $revenue_value;
//							$bookings['sms_confirmation_fee'] = $booking_data['sms'];
//							$bookings['cancellation_fee'] = $booking_data['cancellation'];
//							$bookings['drop_off_at'] = Carbon::now();
//							$bookings['return_at'] = Carbon::now();
//
//////							$bookings['drop_off_at'] = '';
//////							$bookings['return_at'] = '';
//////							$bookings['flight_no_going'] = '';
//////							$bookings['flight_no_return'] = '';
//////							$bookings['vehicle_make'] = '';
//////							$bookings['vehicle_model'] = '';
//////							$bookings['vehicle_color'] = '';
//
//							$booking = Bookings::create($bookings);
//							if (!empty($booking)) {
//								Bookings::findOrFail($booking->id)->update(['booking_id' => Bookings::generate_booking_id($booking->id)]);
//								DB::commit();
//								session('bid', $booking->id);
//
//								return view('parking.payment');
//							} else {
//								DB::rollback();
//								dd('1');
////								return redirect('/payment')->withErrors(['errors' => 'Unable to create booking']);
//							}
//						} else {
//							dd('2');
////							return back()->withErrors(['errors' => 'Unable to find booking information']);
//						}
//					} else {
//						dd('3');
////						return back()->withErrors(['errors' => 'Payment unsuccessful.']);
//					}
//				}
//			}
//		} catch (\Exception $e) {
//			dd($e);
//			abort(404, $e->getMessage());
//		}
//
////		return redirect('/');
//	}

	public function terms()
	{
		return view ('parking.terms');
	}

	public function privacy()
	{
		return view ('parking.privacy');
	}

	public function paypal(Request $request)
	{
		try {
			$form = $request->except(['_token']);

			$data['items'] = [
				[
					'name' => $form['product'],
					'price' => $form['total'],
					'qty' => 1
				]
			];

			$id = DB::getPdo()->lastInsertId();
			$id++;

			$data['invoice_id'] = $id;
			$data['invoice_description'] = "Order #{$id} Invoice";
			$data['return_url'] = url('/payment/success');
			$data['cancel_url'] = url('/payment/cancel');
			$data['total'] = $form['total'];

			$response = $this->provider->setExpressCheckout($data);

			if (!is_null($response['paypal_link'])) {
				$request->session()->put('bookings', $form);
				return redirect($response['paypal_link']);
			} else {
				return back()->withErrors(['errors' => 'Unable to get a response from paypal']);
			}
		} catch (\Exception $e) {
			abort(404, $e->getMessage());
		}
	}
}

