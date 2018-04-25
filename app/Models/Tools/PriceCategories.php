<?php

namespace App\Models\Tools;

use Illuminate\Database\Eloquent\Model;

class PriceCategories extends Model
{
//    protected $with = ['prices'];

    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

//    public function prices()
//    {
//        return $this->hasMany(Prices::class, 'category_id', 'id');
//    }
}
