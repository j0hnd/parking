<?php

namespace App\Models;

class Companies extends BaseModel
{
    protected $fillable = ['company_name', 'mobile_no', 'phone_no', 'email', 'vat_no', 'company_reg', 'insurance_policy', 'park_mark'];

    protected $with = ['carpark'];


    public function carpark()
    {
        return $this->hasOne(Carpark::class, 'id', 'company_id');
    }
}
