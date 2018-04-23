<?php

namespace App\Models;

use App\Models\Tools\CarparkServices;
use Illuminate\Database\Eloquent\Model;

class Services extends BaseModel
{
    protected $fillable = ['product_id', 'service_id', 'deleted_at'];

    protected $dates = ['deleted_at'];

    protected $guarded = ['product_id', 'service_id'];
}
