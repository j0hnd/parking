<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Members extends Model
{
	use SoftDeletes;

    protected $fillable = ['user_id', 'company_id', 'affiliate_id', 'first_name', 'last_name'];

    protected $guarded  = ['user_id'];

    protected $dates    = ['deleted_at', 'created_at', 'updated_at'];

    public $timestamps = true;

    public $with = ['company', 'carpark'];


    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function company()
	{
		return $this->hasOne(Companies::class, 'id', 'company_id');
	}

	public function carpark()
	{
		return $this->hasOne(Carpark::class, 'id', 'company_id');
	}
}
