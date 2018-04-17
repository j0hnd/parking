<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airports extends Model
{
    protected $fillable = [
        'airport_name',
        'description',
        'address',
        'address2',
        'city',
        'county_state',
        'zipcode',
        'country_id',
        'longtitude',
        'latitude',
        'subcategory',
        'image'
    ];

    public $timestamps = true;


    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
