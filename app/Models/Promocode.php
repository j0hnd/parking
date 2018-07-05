<?php

namespace App\Models;

class Promocode extends BaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
    	'code',
    	'reward',
    	'quantity',
        'is_used',
		'expiry_date'
    ];
}
