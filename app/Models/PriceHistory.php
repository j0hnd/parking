<?php

namespace App\Models;

class PriceHistory extends BaseModel
{
    protected $fillable = ['price_id', 'no_of_days', 'price_month', 'price_year', 'price_value', 'changed_by', 'approved_at', 'approved_by'];

    protected $guarded = ['price_id', 'no_of_days', 'price_month', 'price_year', 'price_value', 'approved_by'];

    protected $dates = ['approved_at'];
}
