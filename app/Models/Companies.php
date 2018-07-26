<?php

namespace App\Models;

class Companies extends BaseModel
{
    protected $fillable = [
        'company_name',
        'mobile_no',
        'phone_no',
        'email',
        'vat_no',
        'company_reg',
        'insurance_policy',
        'park_mark'
    ];

    protected $with = ['carpark', 'company_details'];


    public function carpark()
    {
        return $this->hasMany(Carpark::class, 'id', 'company_id');
    }

    public function company_details()
    {
        return $this->hasMany(CompanyDetails::class, 'company_id', 'id');
    }
}
