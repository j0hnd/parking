<?php

namespace App\Models\Tools;

use App\Models\Airports;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $with = ['airport'];

    public function airport()
    {
        return $this->belongsTo(Airports::class, 'country_id', 'id');
    }
}
