<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = true;

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
