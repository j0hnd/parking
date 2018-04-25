<?php

namespace App\Models;

use App\Models\Tools\CarparkServices;
use App\Models\Tools\Prices;

class Products extends BaseModel
{
    protected $fillable = [
        'carpark_id',
        'description',
        'on_arrival',
        'on_return',
        'revenue_share',
        'deleted_at'
    ];

    protected $guarded = ['carpark_id'];

    protected $with = ['carpark', 'airport', 'carpark_services', 'prices'];


    public function carpark()
    {
        return $this->hasOne(Carpark::class, 'id', 'carpark_id');
    }

    public function airport()
    {
        return $this->belongsToMany(Airports::class, 'product_airports', 'product_id', 'id');
    }

    public function carpark_services()
    {
        return $this->belongsToMany(CarparkServices::class, 'services', 'product_id', 'id');
    }

    public function prices()
    {
        return $this->hasMany(Prices::class, 'product_id', 'id');
    }
}