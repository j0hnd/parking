<?php

namespace App\Models;

class ProductAirports extends BaseModel
{
    protected $fillable = ['product_id', 'airport_id', 'deleted_at'];

    protected $guarded = ['product_id', 'airport_id'];

    protected $dates = ['deleted_at'];

    public $timestamps = true;
}
