<?php

namespace App\Models\Tools;

use App\Models\Airports;
use App\Models\Carpark;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $with = ['airport', 'carpark'];


    public function airport()
    {
        return $this->belongsTo(Airports::class, 'country_id', 'id');
    }

    public function carpark()
    {
        return $this->belongsTo(Carpark::class, 'country_id', 'id');
    }
}
