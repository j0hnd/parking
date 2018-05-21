<?php

namespace App\Models\Tools;

use App\Models\BaseModel;


class Fees extends BaseModel
{
    protected $fillable = ['sms_confirmation_fee', 'cancellation_waiver', 'booking_fee'];
}
