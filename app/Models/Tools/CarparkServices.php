<?php

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class CarparkServices extends Model
{
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }
}
