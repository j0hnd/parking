<?php

namespace App\Models;

class ProductAirports extends BaseModel
{
    protected $fillable = ['product_id', 'airport_id', 'deleted_at'];

    protected $guarded = ['product_id', 'airport_id'];

    protected $dates = ['deleted_at'];

    protected $with = ['products'];

    public $timestamps = true;


    public function products()
	{
		return $this->hasMany(Products::class, 'id', 'product_id');
	}
}
