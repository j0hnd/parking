<?php

namespace App\Models;


class AffiliateBookings extends BaseModel
{
	protected $fillable = ['affiliate_code', 'booking_id'];

	protected $guarded = ['affiliate_code', 'booking_id'];
}
