<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDetails extends Model
{
    protected $fillable = ['booking_id', 'no_of_passengers_in_vehicle', 'with_oversize_baggage', 'with_children_pwd'];

    protected $guarded = ['booking_id'];

//    protected $with = ['bookings'];
//
//
//    public function bookings()
//	{
//		return $this->belongsTo(Bookings::class, 'booking_id', 'id');
//	}
}
