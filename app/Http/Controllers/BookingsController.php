<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingFormRequest;
use App\Models\Bookings;
use App\Models\Products;
use App\Models\Customers;
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
                            $duration = $prices->price_start_day." - ".$prices->price_end_day;
                        }

                        $products_list[] = [
                            'order_id'     => $product->id.";".$prices->id,
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
                    'car_model' ,
                    'price_value',
                    'revenue_value',
                    'drop_off_at',
                    'return_at'
                ]);

                $form_customer = $request->only(['customer_id', 'first_name', 'last_name', 'email', 'mobile_no']);

                // extract product id and price id
                $order = explode(';', $form_booking['order_title']);

                // validate product
                $product = Products::findOrFail($order[0]);

                $form_booking['order_title'] = $form_booking['order_title_str'];
                $form_booking['booking_id']  = Bookings::generate_booking_id();
                $form_booking['product_id']  = $order[0];
                $form_booking['price_id']    = $order[1];

                $drop_off_at = new Carbon($form_booking['drop_off_at']);
                $return_at   = new Carbon($form_booking['return_at']);

                $form_booking['drop_off_at'] = $drop_off_at->format('Y-m-d');
                $form_booking['return_at']   = $return_at->format('Y-m-d');

                $form_booking['revenue_value'] = number_format($form_booking['price_value'] * ($product->revenue_share / 100), 2);

                DB::beginTransaction();

                if (empty($form_customer['customer_id'])) {
                    $customer = Customers::create($form_customer);
                } else {
                    $customer = Customers::findOrFail($form_customer['customer_id']);
                }

                $form_booking['customer_id'] = $customer->id;

                if ($booking = Bookings::create($form_booking)) {
                    DB::commit();

                    return redirect('/admin/booking')->with('success', 'Booking is saved.');
                } else {
                    return back()->withError('Unable to save booking');
                }
            } else {
                return back()->withError('Unable to save, invalid request');
            }

        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function edit($id)
    {
        $booking = Bookings::findOrFail($id);
        return view('app.Booking.edit', compact('booking'));
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
}
