<?php

namespace App\Models;

class CompanyDetails extends BaseModel
{
    protected $fillable = ['company_id', 'meta_key', 'meta_value'];

    // protected $with = ['company'];
    //
    //
    // public function company()
    // {
    //     return $this->belongsTo(Companies::class, 'company_id', 'id');
    // }
}
