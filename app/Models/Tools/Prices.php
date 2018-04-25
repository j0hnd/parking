<?php

namespace App\Models\Tools;

use App\Models\BaseModel;

class Prices extends BaseModel
{
    protected $fillable = [
        'product_id',
        'category_id',
        'price_start_day',
        'price_end_day',
        'price_month',
        'price_year',
        'price_value'
    ];

    protected $guarded = ['product_id', 'category_id'];

    protected $with = ['categories'];

    public $timestamps = true;


    public function categories()
    {
        return $this->belongsTo(PriceCategories::class, 'category_id', 'id');
    }
}
