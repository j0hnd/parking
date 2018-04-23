<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAirports extends Model
{
    protected $fillable = ['product_id', 'airport_id'];

    protected $guarded = ['product_id', 'airport_id'];

//    protected $with = ['products'];

    public $timestamps = true;


//    public function products()
//    {
//        return $this->belongsTo(Products::class, 'product_id', 'id');
//    }
//
//    public function airports()
//    {
//        return $this->belongsTo(Airports::class, 'airport_id', 'id');
//    }
}
