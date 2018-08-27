<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupFormRequest;
use App\Mail\ContactUs;
use App\Mail\ForgotPassword;
use App\Mail\RegistrationConfirmation;
use App\Mail\SendBookingConfirmation;
use App\Mail\SendBookingConfirmationVendor;
use App\Mail\Signup;
use App\Mail\NewSignUp;
use App\Models\AffiliateBookings;
use App\Models\Affiliates;
use App\Models\Airports;
use App\Models\BookingDetails;
use App\Models\Bookings;
use App\Models\Carpark;
use App\Models\Customers;
use App\Models\Members;
use App\Models\Messages;
use App\Models\Posts;
use App\Models\Products;
use App\Models\Promocode;
use App\Models\Tools\CarparkServices;
use App\Models\Tools\Common;
use App\Models\Tools\Fees;
use App\Models\Tools\Prices;
use App\Models\Tools\Sessions;
use App\Models\Tools\Subcategories;
use App\Models\User;
use App\Models\Companies;
use Carbon\Carbon;
use Cartalyst\Stripe\Exception\StripeException;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Cookie\CookieJar;
use Srmklive\PayPal\Facades\PayPal;
use Trexology\Promocodes\Model\Promocodes;
use Twilio\Rest\Client;
use DB;
use Hash;
use Sentinel;
use DateTimeZone;


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
    }

    public function index()
    {
    	if (session()->has('sess_id')) {
    		session()->forget('sess_id');
		}

        $airports = Airports::active()->get();

        $selected = Carbon::now(new DateTimeZone(config('app.timezone')));
        $seconds = strtotime($selected->format('H:i'));
        $rounded = round($seconds / (5 * 60)) * (5 * 60);
        $selected_time = date('H:i', $rounded);

		$drop_off_time_interval = Common::get_times($selected_time, '+5 minutes');
		$return_at_time_interval = Common::get_times($selected_time, '+5 minutes');

		$posts = Posts::active()->published()->orderBy('created_at', 'desc')->take(3)->get();
        return view('parking.index', compact('airports', 'drop_off_time_interval', 'return_at_time_interval', 'posts'));
    }

    public function search(Request $request)
    {
    	$form = null;

        if ($request->isMethod('post')) {
			$form = $request->except(['_token']);
            $drop_off_date = explode('-', $form['search']['drop-off-date']);
            $form['search']['drop-off-date'] = trim($drop_off_date[0]);
			$drop_date = trim($drop_off_date[0]);
			$return_date = $form['search']['return-at-date'];
			$products = Products::search($form);
			$results = Products::prepare_data($products);
			$drop_off_time = $form['search']['drop-off-time'];
			$return_at_time = $form['search']['return-at-time'];
			$services = CarparkServices::active()->orderBy('service_name', 'asc')->get();
			$terminals = Subcategories::groupBy('subcategory_name')->orderBy('subcategory_name', 'asc')->get();

			$selected = Carbon::now(new DateTimeZone(config('app.timezone')));
	        $seconds = strtotime($selected->format('H:i'));
	        $rounded = round($seconds / (5 * 60)) * (5 * 60);
	        $selected_time = date('H:i', $rounded);

	        $airports = Airports::active()->get();
	        $drop_off_time_interval  = Common::get_times($selected_time, '+5 minutes', $drop_off_time);
	        $return_at_time_interval = Common::get_times($selected_time, '+5 minutes', $return_at_time);

	        return view('parking.search', [
				'airports' => $airports,
				'drop_off_time_interval' => $drop_off_time_interval,
				'return_at_time_interval' => $return_at_time_interval,
				'results' => $results,
				'form' => $form,
				'services' => $services,
				'terminals' => $terminals,
	            'drop_date' => trim($drop_off_date[0]),
				'return_date' => $form['search']['return-at-date']
			]);
        // } else {
        // 	$drop_off_time = "";
        // 	$return_at_time = "";
        // 	$results = null;
        // 	$services = null;
        // 	$terminals = null;
		}

		abort(404);

		// $selected = Carbon::now(new DateTimeZone(config('app.timezone')));
        // $seconds = strtotime($selected->format('H:i'));
        // $rounded = round($seconds / (5 * 60)) * (5 * 60);
        // $selected_time = date('H:i', $rounded);
		//
        // $airports = Airports::active()->get();
        // $drop_off_time_interval  = Common::get_times($selected_time, '+5 minutes', $drop_off_time);
        // $return_at_time_interval = Common::get_times($selected_time, '+5 minutes', $return_at_time);
		//
        // return view('parking.search', [
		// 	'airports' => $airports,
		// 	'drop_off_time_interval' => $drop_off_time_interval,
		// 	'return_at_time_interval' => $return_at_time_interval,
		// 	'results' => $results,
		// 	'form' => $form,
		// 	'services' => $services,
		// 	'terminals' => $terminals,
        //     'drop_date' => trim($drop_off_date[0]),
		// 	'return_date' => $form['search']['return-at-date']
		// ]);
    }

    public function payment(Request $request)
	{
        $payment_confirm = 0;
        $cancel = 0;

		if ($request->isMethod('post') || isset($request->token)) {
			$form      = $request->only(['products', 'drop_off', 'return_at']);
			$token     = null;
			$details   = null;
			$cancel    = isset($request->cancel) ? 1 : 0;
			$terminals = null;

			if (isset($request->token)) {
				$sessions = Sessions::where('session_id', session('sess_id'))->first();
				$details = json_decode($sessions->response, true);
				$form = json_decode($sessions->requests, true);
				$token = $request->token;
				$payment_confirm = 1;
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

			// $drop_off_time_interval  = Common::get_times(date('H:i'), '+5 minutes');
			// $return_at_time_interval = Common::get_times(date('H:i'), '+5 minutes');

			if (isset($airport->subcategories)) {
				foreach ($airport->subcategories as $terminal) {
	                $terminals .= "<option value='".$terminal->id."'>".$terminal->subcategory_name."</option>";
				}
			}

			$booking_id = session('bid');
			$vehicle_make = json_decode( file_get_contents(public_path('vehicle_data.json')), true );

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
				// 'drop_off_time_interval',
				// 'return_at_time_interval',
				'booking_id',
				'cancel',
				'vehicle_make',
                'payment_confirm',
                'terminals'
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

					$drop_date = str_replace('/', '-', $drop_date);
					$return_date = str_replace('/', '-', $return_date);

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

					$price = $booking_data['total'] - $booking_data['cancellation'] - $booking_data['sms'] - $booking_data['booking_fee'];
					$revenue_value = $price * ($products->revenue_share / 100);

					$user = Sentinel::getUser();
					if (is_null($user)) {
						$user_id = 0;
					} else {
						$user_id = $user->id;
					}

					$bookings['order_title']          = $booking_data['product'];
					$bookings['user_id']              = $user_id;
					$bookings['customer_id']          = $customer->id;
					$bookings['product_id']           = $product_id;
					$bookings['price_id']             = $price_id;
					$bookings['price_value']          = $price;
					$bookings['revenue_value']        = $revenue_value;
					$bookings['client_first_name']    = $form['firstname'];
                    $bookings['client_last_name']     = $form['lastname'];
                    $bookings['client_email']         = $form['email'];
					$bookings['coupon']               = isset($booking_data['coupon']) ? $booking_data['coupon'] : "";
					$bookings['sms_confirmation_fee'] = is_null($booking_data['sms']) ? 0 : $booking_data['sms'];
					$bookings['cancellation_waiver']  = is_null($booking_data['cancellation']) ? 0 : $booking_data['cancellation'];
					$bookings['booking_fees']         = $booking_data['booking_fee'];
					$bookings['car_registration_no']  = $booking_data['car_registration_no'];
					$bookings['vehicle_make']         = $booking_data['vehicle_make'];
					$bookings['vehicle_model']        = $booking_data['vehicle_model'];
					$bookings['vehicle_color']        = $booking_data['vehicle_color'];
					$bookings['drop_off_at']          = date('Y-m-d H:i:s', strtotime($drop_date." ".$drop_time));
					$bookings['return_at']            = date('Y-m-d H:i:s', strtotime($return_date." ".$return_time));

					$booking = Bookings::create($bookings);
					if (!empty($booking)) {
						Bookings::findOrFail($booking->id)->update(['booking_id' => Bookings::generate_booking_id($booking->id)]);

						// reference affiliate
						$affiliate_code = Cookie::get('affiliate');
						$affiliate = Affiliates::active()->where('code', $affiliate_code)->first();
						if (count($affiliate)) {
							$user = User::active()->where('id', $affiliate->travel_agent_id)->first();

							$booking->update(['user_id' => $user->id]);
							AffiliateBookings::create(['affiliate_id' => $affiliate->id, 'booking_id' => $booking->id]);
						}

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
		$response = ['success' => false, 'message' => 'Invalid request'];

		try {
			if ($request->isMethod('post')) {
				$form = $request->except(['_token']);

				$booking = Bookings::where(['id' => $form['bid'], 'is_paid' => 0])->first();
				if ($booking) {
					$drop_off   = $booking->drop_off_at;
					$return_at  = $booking->return_at;
                    $airport_id = $booking->products[0]->airport[0]->id;

					$update = [
						'flight_no_going'    => $form['flight_no_going'],
						'flight_no_return'   => $form['flight_no_return'],
                        'departure_terminal' => $form['departure_terminal'],
                        'arrival_terminal'   => $form['arrival_terminal'],
						'is_paid' => 1,
						'paid_at' => Carbon::now()
					];

					Bookings::where(['id' => $booking->id, 'is_paid' => 0])->update($update);
					$customer = Customers::findOrFail($booking->customer_id);
                    $company  = Companies::findOrFail($booking->products[0]->carpark->company_id);

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

					list($airport_name, $service_name) = explode('-', $booking->order_title);

                    if (!empty($form['departure_terminal'])) {
                        $departure_terminal      = Subcategories::where(['airport_id' => $airport_id, 'id' => $form['departure_terminal']])->first();
                        $departure_terminal_name = $departure_terminal->subcategory_name;
                    } else {
                        $departure_terminal_name = "N/A";
                    }

                    if (!empty($form['arrival_terminal'])) {
                        $arrival_terminal      = Subcategories::where(['airport_id' => $airport_id, 'id' => $form['arrival_terminal']])->first();
                        $arrival_terminal_name = $arrival_terminal->subcategory_name;
                    } else {
                        $arrival_terminal_name = "N/A";
                    }

                    if (!empty($booking->client_first_name)) {
                        $name = ucwords($booking->client_first_name);
                    } elseif (!empty($customer->first_name)) {
                        $name = ucwords($customer->first_name);
                    } else {
                        $name = "";
                    }

					$response = ['success' => true, 'data' => [
						'id'              => $booking->booking_id,
						'name'            => $name,
						'airport'         => $airport_name,
						'service'         => $service_name,
						'drop_off'        => $drop_off->format('d/m/Y H:i'),
						'return_at'       => $return_at->format('d/m/Y H:i'),
                        'vendor_name'     => $booking->products[0]->carpark->name,
                        'vendor_contact'  => empty($booking->products[0]->contact_details->contact_person_name) ? "N/A" : $booking->products[0]->contact_details->contact_person_name,
						'vendor_phone_no' => empty($booking->products[0]->contact_details->contact_person_phone_no) ? "N/A" : $booking->products[0]->contact_details->contact_person_phone_no,
						'vendor_email'    => empty($booking->products[0]->contact_details->contact_person_email) ? "N/A" : $booking->products[0]->contact_details->contact_person_email,
						'registration_no' => empty($booking->car_registration_no) ? "N/A" : strtoupper($booking->car_registration_no),
						'vehicle_make'    => empty($booking->vehicle_make) ? "N/A" : $booking->vehicle_make,
						'vehicle_model'   => empty($booking->vehicle_model) ? "N/A" : $booking->vehicle_model,
						'vehicle_color'   => ucwords($booking->vehicle_color),
                        'flight_no_going'    => $form['flight_no_going'],
                        'flight_no_return'   => $form['flight_no_return'],
                        'departure_terminal' => $departure_terminal_name,
                        'arrival_terminal'   => $arrival_terminal_name
					]];
				} else {
					$response = ['success' => true];
				}
			}
		} catch (\Exception $e) {
			$response['message'] = $e->getMessage();
		}


		return response()->json($response);
	}

	public function booking_destroy(Request $request)
	{
		$response = ['success' => true];

		try {
			if ($request->ajax()) {
				$bid      = $request->get('bid');
				$send_sms = $request->get('send_sms');
				$booking  = Bookings::findOrFail($bid);
				$customer = Customers::findOrFail($booking->customer_id);
				$vendor   = Companies::findORFail($booking->products[0]->carpark->company_id);
				$carpark  = Carpark::findOrFail($booking->products[0]->carpark->id);

                // check if email address is already a customer and have an account
                $user = User::where('email', $booking->client_email);
                if ($user->count() == 0) {
                    $temporary_password = str_random(12);

        			DB::beginTransaction();

        			$user = Sentinel::registerAndActivate([
                        'email'    => $booking->client_email,
                        'password' => $temporary_password
                    ]);

        			if ($user) {
        				// create member info
        				$member = Members::create([
                            'user_id'    => $user->id,
                            'first_name' => $booking->client_first_name,
                            'last_name'  => $booking->client_last_name,
                            'is_active'  => 1
                        ]);

        				// assign role to a user
        				$role = Sentinel::findRoleById(4);
        				$role->users()->attach($user);

						// link current booking to account
						$booking->user_id = $user->id;
						$booking->save();

                        Mail::to($booking->client_email)->send(new NewSignUp([
                            'first_name' => $booking->client_first_name,
                            'email'      => $booking->client_email,
                            'password'   => $temporary_password
                        ]));

        				DB::commit();
                    }
                } else {
                    $booking->user_id = $user->first()->id;
                    $booking->save();
                }

				// get vendor email recipients
				$vendor_recipients = $booking->products[0]->contact_details->contact_person_email;

                $airport_address = $booking->products[0]->airport[0]->airport_name;
                if (!empty($booking->departure_terminal)) {
                    $airport_address = $airport_address. " " . $booking->departure_terminal;
                }

                $airport_address = $airport_address. " - Postcode " . $booking->products[0]->airport[0]->zipcode;

				// send booking confirmation
				Mail::to($customer->email)->send(new SendBookingConfirmation([
					'booking'            => $booking,
					'customer'           => $customer,
                    'carpark_name'       => $carpark->name,
                    'carpark_contact_no' => isset($booking->products[0]->contact_details->contact_person_phone_no) ? $booking->products[0]->contact_details->contact_person_phone_no : "N/A",
                    'airport_details'    => $airport_address,
                    'on_arrival'         => $booking->products[0]->on_arrival,
                    'on_return'          => $booking->products[0]->on_return
				]));

				if (!empty($vendor_recipients)) {
					Mail::to($vendor_recipients)->send(new SendBookingConfirmationVendor([
						'booking'  => $booking,
						'customer' => $customer,
						'vendor'   => $vendor,
						'carpark'  => $carpark
					]));
				}

				$message = Messages::where('subject', 'My Travel Compared Booking Confirmation')
					->where('booking_id', $booking->booking_id)->first();

				if ($message == null) {
					Messages::create([
						'subject'    => 'My Travel Compared Booking Confirmation',
						'message'    => 'My Travel Compared Booking Confirmation',
						'booking_id' => $booking->booking_id,
						'drop_off'   => $booking->drop_off_at,
						'return_at'  => $booking->return_at,
						'order'      => $booking->order_title,
						'name'       => $customer->first_name,
						'status'     => 'unread'
					]);
				}

				// send sms
				if ($send_sms and !empty($customer->mobile_no)) {
					$sms_message = "Thank you for booking your carpark at MyTravelCompared.com. Your booking reference is {$booking->booking_id}";

					$sms_data = [
						"body" => $sms_message,
						"from" => env('TWILIO_NUMBER', '')
					];

					$response['twilio'] = $this->twilio->messages->create($customer->mobile_no, $sms_data);
					Log::debug($response['twilio']);
				}

				Sessions::where('booking_id', $booking->id)->update(['deleted_at' => Carbon::now()]);
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

	public function contact(Request $request)
	{
		if ($request->isMethod('post')) {
			$form = $request->only(['from', 'email', 'message']);
			Mail::to(env('ADMIN_EMAIL'))->send(new ContactUs(['from' => $form['from'], 'email' => $form['email'], 'content' => $form['message']]));
		}

		return view ('parking.contact');
	}

	public function paypal(Promocodes $promocodes, Request $request)
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

			// check coupon
			if (isset($form['coupon'])) {
				$coupon = Promocode::where('code', $form['coupon'])->whereRaw("expiry_date > ?", date('Y-m-d'))->first();
				if (count($coupon)) {
					$data['total'] = $form['total'] - number_format(round($form['total'] * $coupon->reward, PHP_ROUND_HALF_UP), 2);
				}
			}

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

			if ($form['member_type'] == 'member') {
				$user = Sentinel::registerAndActivate($form_user);
			} else {
				$user = Sentinel::register($form_user);
			}

			if ($user) {
				if (isset($form['company_name'])) {
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

				if ($form['member_type'] == 'member') {
					Mail::to($form['email'])->send(new Signup([
						'first_name' => $form['first_name'],
						'email'      => $form['email'],
						'password'   => $temporary_password
					]));
				} else {
					Mail::to($form['email'])->send(new RegistrationConfirmation([
						'first_name' => $form['first_name']
					]));
				}


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

	public function affiliate(CookieJar $cookieJar, Request $request)
	{
		if (empty($request->code)) {
			abort(404);
		}

		try {
			$affiliate = Affiliates::active()->where('code', $request->code);

			if ($affiliate->count()) {
				$cookie = cookie('affiliate', $affiliate->first()->code, 1440);
				return redirect('/')->withCookie($cookie);
			}
		} catch (\Exception $e) {
			abort(404);
		}
	}

	public function get_coupon(Request $request)
	{
		$response = ['success' => false];

		try {
			if ($request->ajax() and $request->isMethod('post')) {
				$form = $request->only(['total', 'coupon']);
				$coupon = Promocodes::where('code', $form['coupon'])->whereRaw("expiry_date > ?", date('Y-m-d'));
				if ($coupon->count()) {
					$discount = number_format(round($form['total'] * $coupon->first()->reward, PHP_ROUND_HALF_UP), 2);
					$percent = $coupon->first()->reward * 100;
					$total = number_format($form['total'] - $discount, 2);
					$response = [
						'success' => true,
						'data'    => [
							'percent'        => $percent."%",
							'discount_value' => $discount,
							'total'          => $total
						]
					];
				}
			}
		} catch (Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	public function stripe(Request $request)
	{
		$response = ['success' => false];

		try {

			if ($request->ajax() and $request->isMethod('post')) {
				$form = $request->except(['_token', 'card_name', 'card_number', 'expiration-month', 'expiration-year', 'cv_code']);
				$expiration = $request->get('expiration-month')."/".$request->get('expiration-year');
				$card = [
					'card_name'   => $request->get('card_name'),
					'card_number' => $request->get('card_number'),
					'expiration'  => $expiration,
					'cvv'         => $request->get('cv_code')
				];

				if (session()->has('sess_id')) {
					$booking = Bookings::select('id')->orderBy('id', 'desc')->first();
					if ($booking) {
						$id = $booking->id;
						$id++;
					} else {
						$id = 1;
					}

					DB::beginTransaction();

					$sess_id = $request->session()->get('sess_id');
					$session = Sessions::where('session_id', $sess_id)->first();
					$session_request  = json_decode($session->requests, true);
					$session_response = json_decode($session->response, true);

					$customer = Customers::where(['email' => $form['email']]);

					if ($customer->count()) {
						$customer_id = $customer->first()->id;
					} else {
						unset($customer);
						$customer['first_name'] = $form['firstname'];
						$customer['last_name']  = $form['lastname'];
						$customer['email']      = $form['email'];
						$customer['mobile_no']  = $form['phoneno'];
						$customer = Customers::create($customer);

						$customer_id = $customer->id;
					}

					list($product_id, $price_id) = explode(':', $form['ids']);
					$drop_off  = str_replace('/', '-', $session_request['drop_off']);
					$return_at = str_replace('/', '-', $session_request['return_at']);

					$user = Sentinel::getUser();
					if (is_null($user)) {
						$user_id = 0;
					} else {
						$user_id = $user->id;
					}

					$product = Products::findOrFail($product_id);
					$price = $form['total'] - $form['cancellation'] - $form['sms'] - $form['booking_fee'];
					$revenue_value = $price * ($product->revenue_share / 100);

					$form['booking_id']           = isset($session_response['booking_id']) ? $session_response['booking_id'] : Bookings::generate_booking_id($id);
					$form['user_id']              = $user_id;
					$form['product_id']           = $product_id;
					$form['price_id']             = $price_id;
					$form['customer_id']          = $customer_id;
                    $form['client_first_name']    = $form['firstname'];
                    $form['client_last_name']     = $form['lastname'];
                    $form['client_email']         = $form['email'];
					$form['order_title']          = $form['product'];
					$form['price_value']          = $price;
					$form['revenue_value']        = number_format($revenue_value, 2);
					$form['cancellation_waiver']  = $form['cancellation'];
					$form['sms_confirmation_fee'] = $form['sms'];
					$form['booking_fees']         = $form['booking_fee'];
					$form['drop_off_at']          = date('Y-m-d H:i:s', strtotime($drop_off));
					$form['return_at']            = date('Y-m-d H:i:s', strtotime($return_at));

					$_booking = Bookings::where('booking_id', $session_response['booking_id']);
					if ($_booking->count()) {
						$booking = Bookings::findOrFail($_booking->first()->id)->update($form);
						$booking_id = $_booking->first()->id;
					} else {
						$booking = Bookings::create($form);
						$booking_id = $booking->id;
						BookingDetails::create(['booking_id' => $booking_id]);

						$sessions = Sessions::where('session_id', $sess_id)->update([
							'booking_id' => $booking->id,
							'response' => json_encode($form)
						]);
					}

					if ($session and $booking) {
						$total = $form['total'];

						// check if transaction includes a coupon
						if (isset($form['coupon'])) {
							$coupon = Promocode::where('code', $form['coupon'])->whereRaw("expiry_date > ?", date('Y-m-d'))->first();
							if (count($coupon)) {
								$total = $form['total'] - number_format(round($form['total'] * $coupon->reward, PHP_ROUND_HALF_UP), 2);
							}
						}

						$data = [
							'amount' => $total,
							'description' => 'Payment for ' . $form['booking_id']
						];

						$stripe_response = self::charge($data, $card, $request);

						if ($stripe_response['success']) {
							DB::commit();
							$response = ['success' => true, 'data' => $booking_id];
						} else {
							DB::rollback();

							$response['message'] = $stripe_response['stripe_message'];
						}
					} else {
						DB::rollback();
					}
				}
			}

		} catch (Exception $e) {
			$response['message'] = $e->getMessage();
		}

		return response()->json($response);
	}

	private static function charge($data = array(), $card = array(), $request)
	{
		if (count($data) == 0 and count($card)) {
			return null;
		}

		$response = ['success' => false];

		// set currency
		$data['currency'] = 'GBP';

		try {
			if (session()->has('sess_id')) {
				$sess_id = $request->session()->get('sess_id');
				$sessions = Sessions::where('session_id', $sess_id)->first();
				$response = json_decode($sessions->response, true);
				list($expiry_month, $expiry_year) = explode('/', $card['expiration']);

				$stripe = Stripe::make(config('services.stripe.key'));

				$token = $stripe->tokens()->create([
					'card' => [
						'number'    => $card['card_number'],
						'exp_month' => $expiry_month,
						'exp_year'  => $expiry_year,
						'cvc'       => $card['cvv'],
					]
				]);

				if (isset($token['id'])) {
					$data['card'] = $token['id'];

					$charge = $stripe->charges()->create($data);

					DB::beginTransaction();

					$response['charge_id'] = $charge['id'];

					$booking = Bookings::where('booking_id', $response['booking_id']);
					if ($booking->count()) {
						// update session data
						$sessions->update(['response' => json_encode($response)]);

						DB::commit();

						$response = ['success' => true, 'stripe_message' => 'Payment Successful'];
					} else {
						DB::rollback();

						$response= ['success' => false, 'stripe_message' => "Invalid booking reference"];
					}
				} else {
					Log::error(Carbon::now() . " - Stripe error (request ID: ". $sess_id ."): Missing token ID.");

					$response = ['success' => false, 'stripe_message' => "Missing token ID"];
				}
			}
		} catch (\StripeException $se) {
			Log::error(Carbon::now() . " - Stripe error (request ID: ". $sess_id ."): " . $se->getMessage());

			$response = ['success' => false, 'stripe_message' =>  $se->getMessage()];
		} catch (\Exception $e) {
			Log::error(Carbon::now() . " - Error in charging a credit card using stripe. With request id  " . $sess_id . $e->getMessage());

			$response = ['success' => false, 'stripe_message' => $e->getMessage()];
		}

		return $response;
	}

	public function get_vehicle_models(Request $request)
	{
		$vehicle_make = json_decode( file_get_contents(public_path('vehicle_data.json')), true );
		$model_str = "<option value=\"\" readonly> -- Vehicle Model -- </option>";
		if (isset($vehicle_make[$request->index])) {
			$models = $vehicle_make[$request->index]['models'];

			foreach ($models as $model) {
				$model_str .= "<option value='".$model['title']."'>".$model['title']."</option>";
			}
		}

		return response()->json(['options' => $model_str]);
	}

	/* email template test only - remove when done */
	// public function email()
    // {
	// 	return view('emails.booking_customer');
	// }
    //
	// public function emailCompany()
    // {
	// 	return view('emails.booking_company');
	// }
    //
	// public function sendTestEmail()
    // {
    //     $booking  = Bookings::findOrFail(69);
    //     $customer = Customers::findOrFail($booking->customer_id);
    //     $vendor   = Companies::findORFail($booking->products[0]->carpark->company_id);
    //     $carpark  = Carpark::findOrFail($booking->products[0]->carpark->id);
    //
    //     $airport_address = $booking->products[0]->airport[0]->airport_name;
    //     if (!empty($booking->departure_terminal)) {
    //         $airport_address = $airport_address. " " . $booking->departure_terminal;
    //     }
    //
    //     $airport_address = $airport_address. " - Postcode " . $booking->products[0]->airport[0]->zipcode;
    //
	// 	$test = [];
    //
    //     Mail::to($booking->products[0]->contact_details->contact_person_email)->send(new SendBookingConfirmationVendor([
    //         'booking' => $booking,
    //         'customer' => $customer,
    //         'vendor' => $vendor,
    //         'carpark' => $carpark
    //     ]));
    //
	// 	Mail::to($customer->email)->send(new SendBookingConfirmation([
	// 		'booking' => $booking,
	// 		'customer' => $customer,
	// 		'carpark_name' => $carpark->name,
	// 		'carpark_contact_no' => isset($booking->products[0]->contact_details->contact_person_phone_no) ? $booking->products[0]->contact_details->contact_person_phone_no : "N/A",
	// 		'airport_details' => $airport_address,
	// 		'on_arrival' => $booking->products[0]->on_arrival,
	// 		'on_return' => $booking->products[0]->on_return
	// 	]));
    //
	// 	// Mail::send('emails.booking_company', $test, function ($m) {
    //     //     $m->from('bookings@mytravelcompared.com', 'My Travel Compared');
    //     //
	// 	// 	$m->to("aarondityalux@gmail.com", "Aaron")->subject('Booking Confirmed!');
	// 	// 	//$m->to("viollan.hermosilla@gmail.com", "Viollan")->subject('Booking Confirmed!');
    //     // });
	// }
	/* email template test only - remove when done */
}
