<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends BaseModel
{
	use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'mobile_no'
    ];

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'customer_id', 'id');
    }
}
