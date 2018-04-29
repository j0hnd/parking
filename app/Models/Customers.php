<?php

namespace App\Models;

class Customers extends BaseModel
{
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
