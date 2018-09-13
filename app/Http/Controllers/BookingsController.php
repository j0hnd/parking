<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingFormRequest;
use App\Mail\SendBookingConfirmation;
use App\Mail\SendBookingConfirmationVendor;
use App\Models\Bookings;
use App\Models\BookingDetails;
use App\Models\Carpark;
use App\Models\Companies;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Airports;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingsController extends Controller
{
    public function index()
    {
        $page_title = "Bookings List";
        $bookings = Bookings::active()->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
        return view('app.Booking.index', compact('page_title', 'bookings'));
    }

    public function create()
    {
        $page_title    = "Create Booking";
        $products_list = null;
        $customers     = Customers::active()->orderBy('last_name', 'asc');
        $products      = Products::active()->orderBy('created_at', 'desc');
        $vehicle_make  = json_decode( file_get_contents(public_path('vehicle_data.json')), true );

        if ($products->count()) {
            foreach ($products->get() as $productIndex => $product) {
                foreach ($product->airport as $i => $airport) {
                    foreach ($product->prices as $prices) {
                        if (!empty($prices->price_year)) {
                            $duration = $prices->price_year;
                        } else if (!empty($prices->price_month)) {
                            $duration = $prices->price_month;
                        } else {
                            $duration = "No of days: ".$prices->no_of_days;
                        }

                        $products_list[] = [
                            'order_id'     => $product->id.";".$prices->id.";".$product->airport[0]->id,
                            'product_name' => $airport->airport_name." - ".$product->carpark->name." - ".$prices->categories->category_name." [£".$prices->price_value."]"
                        ];
                    }
                }
            }
        }

        return view('app.Booking.create', compact('page_title', 'products', 'customers', 'products_list', 'vehicle_make'));
    }

    public function store(BookingFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $form_booking = $request->only([
                    'order_title_str',
                    'order_title',
                    'flight_no_going',
                    'flight_no_return',
                    'car_registration_no',
                    'vehicle_make',
                    'vehicle_model' ,
                    'price_value',
                    'revenue_value',
                    'drop_off_date',
                    'return_at_date',
                    'drop_off_time',
                    'return_at_time',
                    'other_vehicle_make',
                    'other_vehicle_model'
                ]);

                $form_customer = $request->only(['customer_id', 'first_name', 'last_name', 'email', 'mobile_no']);

                // extract product id and price id
                $order = explode(';', $form_booking['order_title']);

                // validate product
                $product = Products::findOrFail($order[0]);

                $form_booking['order_title'] = $form_booking['order_title_str'];
                // $form_booking['booking_id']  = Bookings::generate_booking_id();
                $form_booking['product_id']  = $order[0];
                $form_booking['price_id']    = $order[1];

				if (!empty($form_booking['other_vehicle_make'])) {
					$form_booking['vehicle_make'] = $form_booking['other_vehicle_make'];
				}

                if (!empty($form_booking['other_vehicle_model'])) {
                    $form_booking['vehicle_model'] = $form_booking['other_vehicle_model'];
                }

                unset($form_booking['other_vehicle_make']);
                unset($form_booking['other_vehicle_model']);

                $drop_off_at = new Carbon($form_booking['drop_off_date']);
                $return_at   = new Carbon($form_booking['return_at_date']);

                $form_booking['drop_off_at'] = $drop_off_at->format('Y-m-d')." ".date('H:i:s', strtotime($form_booking['drop_off_time']));
                $form_booking['return_at']   = $return_at->format('Y-m-d')." ".date('H:i:s', strtotime($form_booking['return_at_time']));

                $form_booking['revenue_value'] = number_format($form_booking['price_value'] * ($product->revenue_share / 100), 2);

                unset($form_booking['drop_off_date']);
                unset($form_booking['drop_off_time']);
                unset($form_booking['return_at_date']);
                unset($form_booking['return_at_time']);

                DB::beginTransaction();

                if (empty($form_customer['customer_id'])) {
                    $customer = Customers::create($form_customer);
                } else {
                    $customer = Customers::findOrFail($form_customer['customer_id']);
                }

                $form_booking['customer_id'] = $customer->id;

                if ($booking = Bookings::create($form_booking)) {
                    $booking_id = Bookings::generate_booking_id($booking->id);
                    if (is_null($booking_id)) {
                        return back()->withErrors(['error' => 'Error in generating Booking ID']);
                    }

                    Bookings::findOrFail($booking->id)->update(['booking_id' => $booking_id]);

                    DB::commit();

					$booking  = Bookings::findOrFail($booking->id);
					$customer = Customers::findOrFail($booking->customer_id);
					$vendor   = Companies::findORFail($booking->products[0]->carpark->company_id);
					$carpark  = Carpark::findOrFail($booking->products[0]->carpark->id);

					$airport_address = $booking->products[0]->airport[0]->airport_name;

					if (!empty($booking->departure_terminal)) {
						$airport_address = $airport_address. " " . $booking->departure_terminal;
					}

					$airport_address = $airport_address. " - Postcode " . $booking->products[0]->airport[0]->zipcode;

					if ($form_booking['notify_customer']) {
						Mail::to($customer->email)->send(new SendBookingConfirmation([
							'booking' => $booking,
							'customer' => $customer,
							'carpark_name' => $carpark->name,
							'carpark_contact_no' => isset($booking->products[0]->contact_details->contact_person_phone_no) ? $booking->products[0]->contact_details->contact_person_phone_no : "N/A",
							'airport_details' => $airport_address,
							'on_arrival' => $booking->products[0]->on_arrival,
							'on_return' => $booking->products[0]->on_return
						]));
					}

					if ($form_booking['notify_vendor']) {
						Mail::to($booking->products[0]->contact_details->contact_person_email)->send(new SendBookingConfirmationVendor([
							'booking' => $booking,
							'customer' => $customer,
							'vendor' => $vendor,
							'carpark' => $carpark
						]));
					}

                    return redirect('/admin/booking')->with('success', 'Booking is saved');
                } else {
                    return back()->withErrors(['error' => 'Unable to save booking']);
                }
            } else {
                return back()->withErrors(['error' => 'Unable to save, invalid request']);
            }

        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit($id)
    {
        $booking           = Bookings::findOrFail($id);
        $page_title        = "Edit Booking";
        $products_list     = null;
        $customers         = Customers::active()->orderBy('last_name', 'asc');
        $products          = Products::active()->orderBy('created_at', 'desc');
        $vehicle_make      = json_decode( file_get_contents(public_path('vehicle_data.json')), true );
        $airport           = Airports::findOrFail($booking->products[0]->airport[0]->id);
        $departure_options = null;
        $arrival_options   = null;
		$vehicle_model_names = [];

        if (count($vehicle_make)) {
            foreach ($vehicle_make as $make) {
                $vehicle_make_name[] = $make['title'];
            }

            if (!empty($booking->vehicle_make) and !empty($booking->vehicle_model)) {
            	foreach ($vehicle_make as $make) {
            		if ($make['title'] == $booking->vehicle_make) {
            			foreach ($make['models'] as $model) {
							$vehicle_model_names[] = trim($model['title']);
						}
					}
				}
			}
        } else {
            $vehicle_make_name = null;
        }

        if (isset($airport->subcategories)) {
			foreach ($airport->subcategories as $terminal) {
                if (isset($booking)) {
                    if ($booking->departure_terminal == $terminal->id) {
                        $departure_options .= "<option value='".$terminal->id."' selected>".$terminal->subcategory_name."</option>";
                    } else {
                        $departure_options .= "<option value='".$terminal->id."'>".$terminal->subcategory_name."</option>";
                    }
                } else {
                    $departure_options .= "<option value='".$terminal->id."'>".$terminal->subcategory_name."</option>";
                }
			}

            foreach ($airport->subcategories as $terminal) {
                if (isset($booking)) {
                    if ($booking->arrival_terminal == $terminal->id) {
                        $arrival_options .= "<option value='".$terminal->id."' selected>".$terminal->subcategory_name."</option>";
                    } else {
                        $arrival_options .= "<option value='".$terminal->id."'>".$terminal->subcategory_name."</option>";
                    }
                } else {
                    $arrival_options .= "<option value='".$terminal->id."'>".$terminal->subcategory_name."</option>";
                }
			}
		}

        $vehicle_make_key = array_search($booking->vehicle_make, array_column($vehicle_make, 'title'));
        $vehicle_models = $vehicle_make[$vehicle_make_key]['models'];

        if ($products->count()) {
            foreach ($products->get() as $productIndex => $product) {
                foreach ($product->airport as $i => $airport) {
                    foreach ($product->prices as $prices) {
                        if (!empty($prices->price_year)) {
                            $duration = $prices->price_year;
                        } else if (!empty($prices->price_month)) {
                            $duration = $prices->price_month;
                        } else {
                            $duration = "No of days: ".$prices->no_of_days;
                        }

                        $products_list[] = [
                            'order_id'     => $product->id.";".$prices->id.";".$product->airport[0]->id,
                            'product_name' => $airport->airport_name." - ".$product->carpark->name." - ".$prices->categories->category_name." [".$duration." - £".$prices->price_value."]"
                        ];
                    }
                }
            }
        }

        return view('app.Booking.edit', compact('booking', 'page_title', 'products', 'customers', 'products_list', 'vehicle_make', 'vehicle_models', 'vehicle_make_name', 'departure_options', 'arrival_options', 'vehicle_make_name', 'vehicle_model_names'));
    }

    public function get_vehicle_models(Request $request)
    {
        $vehicle_make = json_decode( file_get_contents(public_path('vehicle_data.json')), true );
        $model_str = "";
        if (isset($vehicle_make[$request->index])) {
			if ($vehicle_make[$request->index]) {
				$models = $vehicle_make[$request->index]['models'];

				foreach ($models as $model) {
					$model_str .= "<option value='".$model['title']."'>".$model['title']."</option>";
				}
			}
		}

        return response()->json(['options' => $model_str]);
    }

    public function update(BookingFormRequest $request)
    {
        try {

            if ($request->isMethod('post')) {
                $id = $request->get('id');

                $form_booking = $request->only([
                    'order_title_str',
                    'order_title',
                    'flight_no_going',
                    'flight_no_return',
                    'car_registration_no',
                    'vehicle_make',
                    'vehicle_model',
                    'vehicle_color',
                    'price_value',
                    'revenue_value',
                    'drop_off_date',
                    'return_at_date',
                    'drop_off_time',
                    'return_at_time',
                    'other_vehicle_make',
                    'other_vehicle_model',
                    'departure_terminal',
                    'arrival_terminal',
                    'client_first_name',
                    'client_last_name',
					'notify_customer',
					'notify_vendor'
                ]);

                $form_booking_details = $request->only([
                    'with_children_pwd',
                    'with_oversize_baggage',
                    'no_of_passengers'
                ]);

                $form_customer = $request->only(['customer_id', 'first_name', 'last_name', 'email', 'mobile_no']);

                // extract product id and price id
                $order = explode(';', $form_booking['order_title']);

                // validate product
                $product = Products::findOrFail($order[0]);

                $form_booking['order_title'] = $form_booking['order_title_str'];
                $form_booking['product_id']  = $order[0];
                $form_booking['price_id']    = $order[1];

				if (!empty($form_booking['other_vehicle_make'])) {
					$form_booking['vehicle_make'] = $form_booking['other_vehicle_make'];
				}

                if (!empty($form_booking['other_vehicle_model'])) {
                    $form_booking['vehicle_model'] = $form_booking['other_vehicle_model'];
                }

                unset($form_booking['other_vehicle_make']);
                unset($form_booking['other_vehicle_model']);

                $drop_off_at = new Carbon(date('Y-m-d', strtotime(str_replace('/', '-', $form_booking['drop_off_date']))));
                $return_at   = new Carbon(date('Y-m-d', strtotime(str_replace('/', '-', $form_booking['return_at_date']))));

                $form_booking['drop_off_at'] = $drop_off_at->format('Y-m-d')." ".date('H:i:00', strtotime($form_booking['drop_off_time']));
                $form_booking['return_at']   = $return_at->format('Y-m-d')." ".date('H:i:00', strtotime($form_booking['return_at_time']));

                if (isset($form_booking['price_value'])) {
                    $form_booking['revenue_value'] = number_format($form_booking['price_value'] * ($product->revenue_share / 100), 2);
                }

                DB::beginTransaction();

                Customers::findOrFail($form_customer['customer_id'])->update($form_customer);

                $form_booking['customer_id'] = $form_customer['customer_id'];

                if (Bookings::findOrFail($id)->update($form_booking)) {
                    $booking_details = BookingDetails::where('booking_id', $id)->first();
                    $booking_details->no_of_passengers_in_vehicle = $form_booking_details['no_of_passengers'];
                    $booking_details->with_oversize_baggage       = isset($form_booking_details['with_oversize_baggage']) ? 1 : 0;
                    $booking_details->with_children_pwd           = isset($form_booking_details['with_children_pwd']) ? 1 : 0;
                    $booking_details->save();

                    DB::commit();

					$booking  = Bookings::findOrFail($id);
					$customer = Customers::findOrFail($booking->customer_id);
					$vendor   = Companies::findORFail($booking->products[0]->carpark->company_id);
					$carpark  = Carpark::findOrFail($booking->products[0]->carpark->id);

					$airport_address = $booking->products[0]->airport[0]->airport_name;

					if (!empty($booking->departure_terminal)) {
						$airport_address = $airport_address. " " . $booking->departure_terminal;
					}

					$airport_address = $airport_address. " - Postcode " . $booking->products[0]->airport[0]->zipcode;

					if (isset($form_booking['notify_customer'])) {
						Mail::to($customer->email)->send(new SendBookingConfirmation([
							'booking' => $booking,
							'customer' => $customer,
							'carpark_name' => $carpark->name,
							'carpark_contact_no' => isset($booking->products[0]->contact_details->contact_person_phone_no) ? $booking->products[0]->contact_details->contact_person_phone_no : "N/A",
							'airport_details' => $airport_address,
							'on_arrival' => $booking->products[0]->on_arrival,
							'on_return' => $booking->products[0]->on_return
						]));
					}

					if (isset($form_booking['notify_vendor'])) {
						Mail::to($booking->products[0]->contact_details->contact_person_email)->send(new SendBookingConfirmationVendor([
							'booking' => $booking,
							'customer' => $customer,
							'vendor' => $vendor,
							'carpark' => $carpark
						]));
					}

                    return redirect('/admin/booking')->with('success', 'Booking has been updated');
                } else {
                    return back()->withErrors(['error' => 'Unable to update booking']);
                }
            } else {
                return back()->withErrors(['error' => 'Unable to update, invalid request']);
            }

        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $form = $request->except('_token');
                $result = Bookings::search($form['search']);
                if (!is_null($result)) {
                    $page_title = "Current Bookings";
                    $bookings = Bookings::wherein('id', $result)->paginate(config('app.item_per_page'));

                    return view('app.Booking.index', compact('bookings', 'page_title'));
                } else {
                    return redirect('/admin/booking')->withErrors(['error' => 'No booking found']);
                }

            } else {
                return redirect('/admin/booking')->withErrors(['error' => 'Invalid request']);
            }
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
