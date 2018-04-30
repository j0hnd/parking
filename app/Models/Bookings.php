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
        'car_model'
    ];

    protected $dates = ['drop_off_at', 'return_at', 'deleted_at'];

    protected $guarded = ['booking_id'];

    protected $with = ['customers'];


    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }

    public static function generate_booking_id()
    {
        $booking = DB::table('bookings')->orderBy('created_at', 'desc')->first();
        if (is_null($booking)) {
            $reference_no = str_pad(1, 6, '0', STR_PAD_LEFT);
        } else {
            $reference_no = str_pad(($booking->id + 1), 6, '0', STR_PAD_LEFT);
        }

        return "CPC-".date('m')."-".$reference_no;
    }
}
