<?php

namespace App\Models;

use App\Models\Tools\Countries;
use App\Models\Tools\Subcategories;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Airports extends BaseModel
{
	use SoftDeletes;
	
    protected $fillable = [
        'airport_name',
        'airport_code',
        'description',
        'address',
        'address2',
        'city',
        'county_state',
        'zipcode',
        'country_id',
        'longtitude',
        'latitude',
        'subcategory',
        'image',
        'deleted_at'
    ];

    protected $with = ['country', 'subcategories'];


    public function country()
    {
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategories::class, 'airport_id', 'id');
        // return $this->belongsTo(Subcategories::class, 'id', 'airport_id');
        // return $this->belongsToMany(Airports::class, 'subcategories', 'airport_id', 'subcategory_id');
    }

//    public function product()
//    {
//        return $this->belongsToMany(Products::class, 'product_airports', 'airport_id', 'product_id');
//    }

    public static function search($search_str)
    {
        $result = DB::table('airports')
                    ->join('countries', 'countries.id', '=', 'airports.country_id')
                    ->whereNull('airports.deleted_at')
                    ->where(function ($query) use ($search_str) {
                        $query->orWhere('airports.airport_name', 'like', "{$search_str}%");
                        $query->orWhere('airports.city', 'like', "{$search_str}%");
                        $query->orWhere('airports.county_state', 'like', "{$search_str}%");
                        $query->orWhere('countries.country', 'like', "{$search_str}%");
                    });

        return $result->count() ? $result : null;
    }
}
