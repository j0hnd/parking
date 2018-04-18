<?php

namespace App\Models;

use App\Models\Tools\Countries;
use Illuminate\Database\Eloquent\Model;
use DB;

class Airports extends Model
{
    protected $fillable = [
        'airport_name',
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

    protected $with = ['country'];

    public $timestamps = true;


    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function country()
    {
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

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
