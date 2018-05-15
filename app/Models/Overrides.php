<?php

namespace App\Models;

class Overrides extends BaseModel
{
    protected $fillable = ['product_id', 'override_dates', 'override_price'];

    protected $guarded = ['product_id'];

    protected $with = ['products'];


    public function products()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
