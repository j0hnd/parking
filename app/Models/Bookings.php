<?php

namespace App\Models;

class Bookings extends BaseModel
{
    protected $fillable = [
        'booking_id',
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
}
