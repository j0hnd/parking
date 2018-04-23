<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'carpark_id',
        'description',
        'on_arrival',
        'on_return',
        'revenue_share'
    ];

    protected $guarded = ['carpark_id'];

    protected $with = ['carpark', 'airport'];

    public $timestamps = true;


    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function carpark()
    {
        return $this->hasOne(Carpark::class, 'id', 'carpark_id');
    }

    public function airport()
    {
        return $this->belongsToMany(Airports::class, 'product_airports', 'product_id', 'id');
    }
}
