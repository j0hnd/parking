<?php

namespace App\Models;

use App\Models\Tools\Prices;

class ProductAirports extends BaseModel
{
    protected $fillable = ['product_id', 'airport_id', 'deleted_at'];

    protected $guarded = ['product_id', 'airport_id'];

    protected $dates = ['deleted_at'];

    protected $with = ['products', 'prices'];

    public $timestamps = true;


    public function products()
	{
		return $this->hasMany(Products::class, 'id', 'product_id');
	}

	public function prices()
	{
		return $this->hasMany(Prices::class, 'product_id', 'product_id');
	}
}
