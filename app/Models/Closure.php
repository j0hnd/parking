<?php

namespace App\Models;

class Closure extends BaseModel
{
    protected $fillable = [
    	'product_id', 'closed_dates', 'deleted_at'
	];

    protected $guarded = [
    	'product_id'
	];

    protected $dates = [
    	'deleted_at'
	];


    public function product()
	{
		return $this->belongsTo(Products::class, 'product_id', 'id');
	}
}
