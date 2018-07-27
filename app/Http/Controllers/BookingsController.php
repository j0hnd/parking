<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingFormRequest;
use App\Models\Bookings;
use App\Models\BookingDetails;
use App\Models\Products;
use App\Models\Customers;
use App\Models\Airports;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                            'product_name' => $airport->airport_name." - ".$product->carpark->name." - ".$prices->categories->category_name." [".$duration." - £".$prices->price_value."]"
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

                if (!empty($form_booking['other_vehicle_model'])) {
                    $form_booking['vehicle_model'] = $form_booking['other_vehicle_model'];
                }

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

        if (count($vehicle_make)) {
            foreach ($vehicle_make as $make) {
                $vehicle_make_name[] = $make['value'];
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

        $vehicle_make_key = array_search($booking->vehicle_make, array_column($vehicle_make, 'value'));
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

        return view('app.Booking.edit', compact('booking', 'page_title', 'products', 'customers', 'products_list', 'vehicle_make', 'vehicle_models', 'vehicle_make_name', 'departure_options', 'arrival_options'));
    }

    public function get_vehicle_models(Request $request)
    {
        $vehicle_make = json_decode( file_get_contents(public_path('vehicle_data.json')), true );
        $model_str = "";
        if ($vehicle_make[$request->index]) {
            $models = $vehicle_make[$request->index]['models'];

            foreach ($models as $model) {
                $model_str .= "<option value='".$model['value']."'>".$model['title']."</option>";
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
                    'other_vehicle_model',
                    'departure_terminal',
                    'arrival_terminal',
                    'client_first_name',
                    'client_last_name',
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

                if (!empty($form_booking['other_vehicle_model'])) {
                    $form_booking['vehicle_model'] = $form_booking['other_vehicle_model'];
                }

                unset($form_booking['other_vehicle_model']);

                $drop_off_at = new Carbon($form_booking['drop_off_date']);
                $return_at   = new Carbon($form_booking['return_at_date']);

                $form_booking['drop_off_at'] = $drop_off_at->format('Y-m-d')." ".date('H:i:s', strtotime($form_booking['drop_off_time']));
                $form_booking['return_at']   = $return_at->format('Y-m-d')." ".date('H:i:s', strtotime($form_booking['return_at_time']));

                if (isset($form_booking['price_value'])) {
                    $form_booking['revenue_value'] = number_format($form_booking['price_value'] * ($product->revenue_share / 100), 2);
                }

                unset($form_booking['drop_off_date']);
                unset($form_booking['drop_off_time']);
                unset($form_booking['return_at_date']);
                unset($form_booking['return_at_time']);

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
