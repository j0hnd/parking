<?php

namespace App\Models;

class Products extends BaseModel
{
    protected $fillable = [
        'carpark_id',
        'description',
        'on_arrival',
        'on_return',
        'revenue_share'
    ];

    protected $guarded = ['carpark_id'];

    protected $with = ['carpark', 'airport'];


    public function carpark()
    {
        return $this->hasOne(Carpark::class, 'id', 'carpark_id');
    }

    public function airport()
    {
        return $this->belongsToMany(Airports::class, 'product_airports', 'product_id', 'id');
    }
}
