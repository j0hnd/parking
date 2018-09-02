<?php

namespace App\Models;

class LandingPages extends BaseModel
{
    protected $fillable = [
        'airport_id', 'name', 'slug', 'description_1', 'deleted_at'
    ];

    protected $guarded = ['airport'];


    public function airport()
    {
        return $this->belongsTo(Airports::class, 'airport_id', 'id');
    }
}
