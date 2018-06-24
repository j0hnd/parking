<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupFormRequest;
use App\Mail\ForgotPassword;
use App\Mail\SendBookingConfirmation;
use App\Mail\Signup;
use App\Models\Airports;
use App\Models\BookingDetails;
use App\Models\Bookings;
use App\Models\Carpark;
use App\Models\Customers;
use App\Models\Members;
use App\Models\Messages;
use App\Models\Posts;
use App\Models\Products;
use App\Models\Tools\CarparkServices;
use App\Models\Tools\Common;
use App\Models\Tools\Fees;
use App\Models\Tools\Prices;
use App\Models\Tools\Sessions;
use App\Models\Tools\Subcategories;
use App\Models\User;
use App\Models\Companies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Facades\PayPal;
use Twilio\Rest\Client;
use DB;
use Hash;
use Sentinel;


class ParkingAppController extends Controller
{
	private $provider;
	private $twilio;

    public function __construct()
    {
        $this->middleware('guest');
		$this->provider = PayPal::setProvider('express_checkout');
		$this->provider->setApiCredentials(config('paypal'));

		$this->twilio = new Client(env('TWILIO_SID', ''), env('TWILIO_AUTHTOKEN', ''));
		// $this->twilio = new Client($sid, $token);
    }

    public function index()
    {
    	if (session()->has('sess_id')) {
    		session()->forget('sess_id');
		}

        $airports = Airports::active()->get();
		$drop_off_time_interval = Common::get_times(date('H:i'), '+5 minutes');
		$return_at_time_interval = Common::get_times(date('H:i'), '+5 minutes');
		$posts = Posts::active()->published()->orderBy('created_at', 'desc')->take(3)->get();
        return view('parking.index', compact('airports', 'drop_off_time_interval', 'return_at_time_interval', 'posts'));
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
			$services = CarparkServices::active()->orderBy('service_name', 'asc')->get();
			$terminals = Subcategories::groupBy('subcategory_name')->orderBy('subcategory_name', 'asc')->get();
        } else {
        	$drop_off_time = "";
        	$return_at_time = "";
		}

        $airports = Airports::active()->get();
        $drop_off_time_interval  = Common::get_times(date('H:i'), '+5 minutes', $drop_off_time);
        $return_at_time_interval = Common::get_times(date('H:i'), '+5 minutes', $return_at_time);

        return view('parking.search', [
			'airports' => $airports,
			'drop_off_time_interval' => $drop_off_time_interval,
			'return_at_time_interval' => $return_at_time_interval,
			'results' => $results,
			'form' => $form,
			'services' => $services,
			'terminals' => $terminals
		]);
    }

    public function payment(Request $request)
	{
		if ($request->isMethod('post') || isset($request->token)) {
			$form = $request->only(['products', 'drop_off', 'return_at']);
			$token = null;
			$details = null;
			$cancel = isset($request->cancel) ? $request->cancel : 0;

			if (isset($request->token)) {
				$sessions = Sessions::where('session_id', session('sess_id'))->first();
				$details = json_decode($sessions->response, true);
				$form = json_decode($sessions->requests, true);
				$token = $request->token;
			} else {
				if (!session()->has('sess_id')) {
					$sessions = Sessions::create(['request_id' => session()->getId(), 'requests' => json_encode($form)]);
					if ($sessions) {
						$request->session()->put('sess_id', $sessions->session_id);
					} else {
						abort(502);
					}
				}
			}

			list($index, $product_id, $airport_id, $price_id, $price_value) = explode(':', $form['products']);
			list($drop_off_date, $drop_off_time) = explode(" ", $form['drop_off']);
			list($return_at_date, $return_at_time) = explode(" ", $form['return_at']);

			$airport = Airports::findOrFail($airport_id);
			$product = Products::findOrFail($product_id);
			$price   = Prices::findOrFail($price_id);
			$carpark = Carpark::findOrFail($product->carpark_id);

			$booking_fee          = Fees::active()->where('fee_name', 'booking_fee')->first();
			$sms_confirmation_fee = Fees::active()->where('fee_name', 'sms_confirmation_fee')->first();
			$cancellation_waiver  = Fees::active()->where('fee_name', 'cancellation_waiver')->first();

			$drop_off_time_interval  = Common::get_times(date('H:i'), '+5 minutes');
			$return_at_time_interval = Common::get_times(date('H:i'), '+5 minutes');

			$booking_id = session('bid');

			return view('parking.payment', compact(
				'product',
				'airport',
				'carpark',
				'price',
				'price_value',
				'booking_fee',
				'sms_confirmation_fee',
				'cancellation_waiver',
				'drop_off_date',
				'drop_off_time',
				'return_at_date',
				'return_at_time',
				'token',
				'details',
				'form',
				'drop_off_time_interval',
				'return_at_time_interval',
				'booking_id',
				'cancel'
			));
		}
	}

	public function paypal_success(Request $request)
	{
		$paypal_response = $request->all();

		if (empty($paypal_response)) {
			abort(502);
		}

		if (isset($paypal_response['token'])) {
			$response = $this->provider->getExpressCheckoutDetails($paypal_response['token']);
			if ($response['ACK'] == 'Success') {
				if ($request->session()->has('sess_id')) {
					$sess_id = session('sess_id');

					$session = Sessions::where('session_id', $sess_id)->first();
					$others = json_decode($session->requests, true);
					$booking_data = json_decode($session->response, true);

					list($drop_date, $drop_time) = explode(' ', $others['drop_off']);
					list($return_date, $return_time) = explode(' ', $others['return_at']);
					list($product_id, $price_id) = explode(':', $booking_data['ids']);

					DB::beginTransaction();

					// save customer information
					$customer_obj = Customers::where('email', $booking_data['email']);
					if ($customer_obj->count()) {
						$customer = $customer_obj->first();
					} else {
						$customer['first_name'] = $booking_data['firstname'];
						$customer['last_name'] = $booking_data['lastname'];
						$customer['email'] = $booking_data['email'];
						$customer['mobile_no'] = $booking_data['phoneno'];
						$customer = Customers::create($customer);
					}

					// save booking data
					$products = Products::findOrFail($product_id);
					$revenue_value = number_format(($booking_data['total'] * 1) * ($products->revenue_share / 100), 2);

					$bookings['order_title'] = $booking_data['product'];
					$bookings['customer_id'] = $customer->id;
					$bookings['product_id'] =  $product_id;
					$bookings['price_id'] = $price_id;
					$bookings['price_value'] = $booking_data['total'];
					$bookings['revenue_value'] = $revenue_value;
					$bookings['sms_confirmation_fee'] = is_null($booking_data['sms']) ? 0 : $booking_data['sms'];
					$bookings['cancellation_waiver'] = is_null($booking_data['cancellation']) ? 0 : $booking_data['cancellation'];
					$bookings['booking_fees'] = $booking_data['booking_fee'];
					$bookings['car_registration_no'] = $booking_data['car_registration_no'];
					$bookings['vehicle_model'] = $booking_data['vehicle_model'];
					$bookings['vehicle_color'] = $booking_data['vehicle_color'];
					$bookings['drop_off_at'] = date('Y-m-d H:i:s', strtotime($drop_date));
					$bookings['return_at'] = date('Y-m-d H:i:s', strtotime($return_date));

					$booking = Bookings::create($bookings);
					if (!empty($booking)) {
						Bookings::findOrFail($booking->id)->update(['booking_id' => Bookings::generate_booking_id($booking->id)]);
						DB::commit();
						$request->session()->put('bid', $booking->id);

						return redirect('/payment/token=' . $paypal_response['token']);
					} else {
						DB::rollback();
						abort(502);
					}
				}
			}
		} else {
			abort(502);
		}
	}

	public function paypal_cancel(Request $request)
	{
		return redirect()->to('/payment/token='.$request->get('token').'/cancel=1');
	}

	public function update_booking_details(Request $request)
	{
		if ($request->isMethod('post')) {
			$form = $request->except(['_token']);
			$booking = Bookings::where(['id' => $form['bid'], 'is_paid' => 0])->first();
			if ($booking) {
				$drop_off = Carbon::createFromTimestamp(strtotime($form['drop_off_at']));
				$return_at = Carbon::createFromTimestamp(strtotime($form['return_at']));

				$update = [
					'drop_off_at' => $drop_off->format('Y-m-d H:i'),
					'return_at' => $return_at->format('Y-m-d H:i'),
					'flight_no_going' => $form['flight_no_going'],
					'flight_no_return' => $form['flight_no_return'],
					'is_paid' => 1,
					'paid_at' => Carbon::now()
				];

				Bookings::where(['id' => $booking->id, 'is_paid' => 0])->update($update);

				$details = [
					'booking_id' => $form['bid'],
					'no_of_passengers_in_vehicle' => $form['no_of_passengers_in_vehicle'],
					'with_oversize_baggage' => $form['with_oversize_baggage'],
					'with_children_pwd' => $form['with_children_pwd'],
				];

				if (BookingDetails::where(['booking_id' => $form['bid']])->count()) {
					BookingDetails::where(['booking_id' => $form['bid']])->update([
						'no_of_passengers_in_vehicle' => $form['no_of_passengers_in_vehicle'],
						'with_oversize_baggage' => $form['with_oversize_baggage'],
						'with_children_pwd' => $form['with_children_pwd'],
					]);
				} else {
					BookingDetails::create($details);
				}

				return response()->json(['success' => true, 'data' => $booking->booking_id]);
			}
		}
	}

	public function booking_destroy(Request $request)
	{
		$response = ['success' => true];

		try {
			if ($request->ajax()) {
				$bid = $request->get('bid');
				$send_sms = $request->get('send_sms');
				$booking = Bookings::findOrFail($bid);
				$customer = Customers::findOrFail($booking->customer_id);

				$mail_data = [
					'firstname' => $customer->first_name,
					'order' => $booking->order_title,
					'drop_off' => $booking->drop_off_at->format('m/d/Y H:i'),
					'return_at' => $booking->return_at->format('m/d/Y H:i'),
					'booking_id' => $booking->booking_id
				];

				// send booking confirmation
				Mail::to($customer->email)->send(new SendBookingConfirmation($mail_data));
				Messages::create([
					'subject' => 'My Travel Compared Booking Confirmation',
					'booking_id' => $booking->booking_id,
					'drop_off' => $booking->drop_off_at->format('Y-m-d h:i:s'),
					'return_at' => $booking->return_at->format('Y-m-d h:i:s'),
					'order' => $booking->order_title,
					'name' => $customer->first_name,
					'status' => 'unread'
				]);
				// send sms
				if ($send_sms) {
					$message = $this->twilio->messages
						  ->create($customer->mobile_no,
								   array(
									   "body" => "SMS Confirmation",
									   "from" => env('TWILIO_NUMBER', '')
								   )
						  );

					$response['twilio'] = $message;
				}

				$sess_id = session('sess_id');
				Sessions::where('session_id', $sess_id)->update(['deleted_at' => Carbon::now()]);
				session()->flush();

				$response['success'] = true;
			}
		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	public function terms()
	{
		return view ('parking.terms');
	}

	public function privacy()
	{
		return view ('parking.privacy');
	}

	public function contact()
	{
		return view ('parking.contact');
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

			$booking = Bookings::select('id')->orderBy('id', 'desc')->first();
			if ($booking) {
				$id = $booking->id;
				$id++;
			} else {
				$id = 1;
			}


			$data['invoice_id'] = $id;
			$data['invoice_description'] = "Order #{$id} Invoice";
			$data['return_url'] = url('/paypal/success');
			$data['cancel_url'] = url('/paypal/cancel');
			$data['total'] = $form['total'];

			$response = $this->provider->setExpressCheckout($data);

			if (!is_null($response['paypal_link'])) {
				if ($request->session()->has('sess_id')) {
					if (Sessions::where('session_id', session('sess_id'))->update(['booking_id' => $id, 'response' => json_encode($form)])) {
						return redirect($response['paypal_link']);
					}
				}

				return back()->withErrors(['errors' => 'Unable to create session.']);
			} else {
				return back()->withErrors(['errors' => 'Unable to get a response from paypal']);
			}
		} catch (\Exception $e) {
			abort(404, $e->getMessage());
		}
	}

	public function forgot_password()
	{
		return view('member-portal.forgot-password');
	}

	public function process_forgot_password(Request $request)
	{
		if ($request->isMethod('post')) {
			$email = $request->get('email');

			if (empty($email)) {
				return back()->withErrors(['errors' => 'Please input your registered email address']);
			}

			$user = User::where('email', $email)->whereNull('deleted_at');
			if ($user->count()) {
				$temporary_password = str_random(12);
				$hash = Hash::make($temporary_password);

				if ($user->update(['password' => $hash])) {
					Mail::to($email)->send(new ForgotPassword(['password' => $temporary_password]));
					return back()->with('success', 'Temporary password has been sent to your registered email address.');
				} else {
					return back()->withErrors(['errors' => 'Unable to update your password']);
				}
			} else {
				return back()->withErrors(['errors' => 'Email not registered']);
			}
		}

		return back()->withErrors(['errors' => 'Unable to update your password']);
	}

	public function signup()
	{
		return view('member-portal.signup');
	}

	public function save_signup(SignupFormRequest $request)
	{
		if ($request->isMethod('post')) {
			$form = $request->except(['_token']);
			$temporary_password = str_random(12);
			$form_user = [
				'email'    => $form['email'],
				'password' => $temporary_password
			];

			$role = ['vendor' => 2, 'travel_agent' => 3, 'member' => 4];

			DB::beginTransaction();

			if ($user = Sentinel::registerAndActivate($form_user)) {
				if (isset($form['company_nam'])) {
					$company = Companies::create(['company_name' => $form['company_name']]);
					$member_data = [
						'user_id'    => $user->id,
						'company_id' => $company->id,
						'first_name' => $form['first_name'],
						'last_name'  => $form['last_name'],
						'is_active'  => 1
					];
				} else {
					$member_data = [
						'user_id'    => $user->id,
						'first_name' => $form['first_name'],
						'last_name'  => $form['last_name'],
						'is_active'  => 1
					];
				}

				// create member info
				$member = Members::create($member_data);

				// assign role to a user
				$role = Sentinel::findRoleById($role[$form['member_type']]);
				$role->users()->attach($user);

				Mail::to($form['email'])->send(new Signup([
					'first_name' => $form['first_name'],
					'email'      => $form['email'],
					'password'   => $temporary_password
				]));

				DB::commit();

				return back()->with('success', 'Thank you for signing up and check your email address for your login credentials');
			} else {
				DB::rollback();

				return back()->with('error', 'Error in adding new user');
			}
		}
	}

	public function show_post(Request $request)
	{
		$post = Posts::active()->published()->where('slug', $request->post);
		if ($post->count()) {
			$post  = $post->first();
			$posts = Posts::active()->published()->where('id', '!=', $post->id)->inRandomOrder()->take(2)->get();
			$next  = Posts::active()->published()->where('id', ($post->id + 1))->first();
			$prev  = Posts::active()->published()->where('id', ($post->id - 1))->first();
		} else {
			abort(404);
		}

		return view('parking.blog', compact('post', 'posts', 'next', 'prev'));
	}

	public function filter_result(Request $request)
	{
		$response = ['success' => false];

		try {
			if ($request->ajax() and $request->isMethod('post')) {
				$form = $request->except(['_token']);
				parse_str($form['data'], $form);
				$form['filter'] = $request->filter;
				$products = Products::search($form);
				$results = Products::prepare_data($products);

				$html = view('parking.partials._cards', compact('results'))->render();
				$response = ['success' => true, 'html' => $html];
			}
		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	public function filter(Request $request)
	{
		$response = ['success' => false];

		try {
			if ($request->ajax() and $request->isMethod('post')) {
				$form = $request->except(['_token']);
				parse_str($form['data'], $form);
				$form['sub'] = ['type' => $request->type, 'value' => $request->value];
				$products = Products::search($form);
				$results = Products::prepare_data($products);

				$html = view('parking.partials._cards', compact('results'))->render();
				$response = ['success' => true, 'html' => $html];
			}
		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}
}
