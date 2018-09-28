<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDetails extends BaseModel
{
	use SoftDeletes;

    protected $fillable = ['company_id', 'parent_id', 'meta_key', 'meta_value'];

    // protected $with = ['company'];
    //
    //
    // public function company()
    // {
    //     return $this->belongsTo(Companies::class, 'company_id', 'id');
    // }
}
