<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Overrides extends BaseModel
{
	use SoftDeletes;

    protected $fillable = ['product_id', 'override_dates', 'override_price'];

    protected $guarded = ['product_id'];

//    protected $with = ['products'];


//    public function products()
//    {
//        return $this->belongsTo(Products::class, 'id', 'product_id');
//    }
}
