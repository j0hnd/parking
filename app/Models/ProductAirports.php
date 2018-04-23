<?php

namespace App\Models;

class ProductAirports extends BaseModel
{
    protected $fillable = ['product_id', 'airport_id'];

    protected $guarded = ['product_id', 'airport_id'];

    public $timestamps = true;
}
