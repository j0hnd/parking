<?php

namespace App\Models;


class AffiliateBookings extends BaseModel
{
	protected $fillable = ['affiliate_id', 'booking_id'];

	protected $guarded = ['affiliate_id', 'booking_id'];
}
