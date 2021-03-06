<?php

namespace App\Models;

use DB;

class Bookings extends BaseModel
{
    protected $fillable = [
        'booking_id',
        'product_id',
        'price_id',
        'customer_id',
        'order_title',
        'price_value',
        'revenue_value',
        'drop_off_at',
        'return_at',
        'flight_no_going',
        'flight_no_return',
        'car_registration_no',
        'vehicle_make',
        'vehicle_model',
        'vehicle_color'
    ];

    protected $dates = ['drop_off_at', 'return_at', 'deleted_at'];

    protected $guarded = ['booking_id'];

    protected $with = ['customers'];


    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    public static function generate_booking_id($booking_id)
    {
        if (is_null($booking_id) or empty($booking_id) or $booking_id == "") {
            return null;
        }

        $reference_no = str_pad(($booking_id), 6, '0', STR_PAD_LEFT);
        return "CPC-".date('m')."-".$reference_no;
    }

    public static function search($search_str)
    {
        $result = DB::table('bookings')
                    ->select('bookings.id')
                    ->join('customers', 'customers.id', '=', 'bookings.customer_id')
                    ->whereNull('bookings.deleted_at')
                    ->where(function ($query) use ($search_str) {
                        $query->orWhere('bookings.booking_id', 'like', "{$search_str}%");
                        $query->orWhere('bookings.order_title', 'like', "{$search_str}%");
                        $query->orWhere('bookings.flight_no_going', 'like', "{$search_str}%");
                        $query->orWhere('bookings.flight_no_return', 'like', "{$search_str}%");
                        $query->orWhere('bookings.vehicle_make', 'like', "{$search_str}%");
                        $query->orWhere('bookings.vehicle_model', 'like', "{$search_str}%");
                        $query->orWhere('bookings.vehicle_color', 'like', "{$search_str}%");
                        $query->orWhere('customers.first_name', 'like', "{$search_str}%");
                        $query->orWhere('customers.last_name', 'like', "{$search_str}%");
                        $query->orWhere('customers.email', 'like', "{$search_str}%");
                    });

        if ($result->count()) {
            foreach ($result->get() as $item) {
                $booking_ids[] = $item->id;
            }
        }

        return isset($booking_ids) ? $booking_ids : null;
    }
}
