<?php

namespace App\Models;

use App\Models\Tools\Countries;
use DB;

class Carpark extends BaseModel
{
    protected $fillable = [
    	'company_id',
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

    protected $with = ['country', 'company'];


    public function country()
    {
        return $this->hasOne(Countries::class, 'id', 'country_id');
    }

    public function company()
    {
        return $this->belongsTo(Companies::class, 'company_id', 'id');
    }

    public static function search($search_str)
    {
        $result = DB::table('carparks')
            ->join('countries', 'countries.id', '=', 'carparks.country_id')
            ->join('companies', 'companies.id', '=', 'carparks.company_id')
            ->whereNull('carparks.deleted_at')
            ->whereNull('companies.deleted_at')
            ->where(function ($query) use ($search_str) {
                $query->orWhere('companies.company_name', 'like', "{$search_str}%");
                $query->orWhere('carparks.name', 'like', "{$search_str}%");
                $query->orWhere('carparks.city', 'like', "{$search_str}%");
                $query->orWhere('carparks.county_state', 'like', "{$search_str}%");
                $query->orWhere('countries.country', 'like', "{$search_str}%");
            });

        return $result->count() ? $result : null;
    }


}
