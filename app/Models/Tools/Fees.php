<?php

namespace App\Models\Tools;

use App\Models\BaseModel;


class Fees extends BaseModel
{
    protected $fillable = ['fee_name', 'amount'];
}
