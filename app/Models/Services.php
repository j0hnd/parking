<?php

namespace App\Models;

use App\Models\Tools\CarparkServices;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends BaseModel
{
	use SoftDeletes;

    protected $fillable = ['product_id', 'service_id', 'deleted_at'];

    protected $dates = ['deleted_at'];

    protected $guarded = ['product_id', 'service_id'];
}
