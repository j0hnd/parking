<?php

namespace App\Models;

use App\Models\Tools\Countries;
use Illuminate\Database\Eloquent\Model;
use DB;

class Carpark extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'address2',
        'city',
        'county_state',
        'zipcode',
        'country_id',
        'longtitude',
        'latitude',
        'image',
        'deleted_at'
    ];

    protected $with = ['country'];

    public $timestamps = true;


    public function country()
    {
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public static function search($search_str)
    {
        $result = DB::table('carparks')
            ->join('countries', 'countries.id', '=', 'carparks.country_id')
            ->whereNull('carparks.deleted_at')
            ->where(function ($query) use ($search_str) {
                $query->orWhere('carparks.name', 'like', "{$search_str}%");
                $query->orWhere('carparks.city', 'like', "{$search_str}%");
                $query->orWhere('carparks.county_state', 'like', "{$search_str}%");
                $query->orWhere('countries.country', 'like', "{$search_str}%");
            });

        return $result->count() ? $result : null;
    }
}
