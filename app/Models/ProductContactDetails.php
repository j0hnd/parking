<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductContactDetails extends Model
{
	use SoftDeletes;

    protected $fillable = ['carpark_id', 'product_id', 'contact_person_name', 'contact_person_email', 'contact_person_phone_no', 'is_active'];

    protected $guarded = ['carpark_id', 'product_id'];
}
