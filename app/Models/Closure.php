<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Closure extends BaseModel
{
	use SoftDeletes;

    protected $fillable = [
    	'product_id', 'closed_date', 'deleted_at'
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
