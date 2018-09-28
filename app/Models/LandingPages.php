<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class LandingPages extends BaseModel
{
	use SoftDeletes;

    protected $fillable = [
        'airport_id', 'name', 'slug', 'description_1', 'deleted_at'
    ];

    protected $guarded = ['airport'];


    public function airport()
    {
        return $this->belongsTo(Airports::class, 'airport_id', 'id');
    }
}
