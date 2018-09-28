<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class AffiliateBookings extends BaseModel
{
	use SoftDeletes;

	protected $fillable = ['affiliate_id', 'booking_id'];

	protected $guarded = ['affiliate_id', 'booking_id'];

	protected $with = ['affiliates'];


	public function affiliates()
	{
		return $this->hasMany(Affiliates::class, 'id', 'affiliate_id');
//		return $this->belongsToMany(Affiliates::class, 'affiliate_bookings', 'affiliate_id', 'id');
	}

//	public function bookings()
//	{
//		return $this->belongsToMany(Bookings::class, 'affiliate_bookings', 'booking_id', 'id');
//	}
}
