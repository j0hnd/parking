<?php

namespace App\Models;

use Illuminate\Support\Str;


class Affiliates extends BaseModel
{
	protected $fillable = ['code', 'travel_agent_id', 'percent_admin', 'percent_vendor', 'percent_travel_agent'];

	protected $guarded = ['code'];


	/**
	 * Boot function for using with User Events
	 *
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::creating(function ($model)
		{
			$model->code = (string) Str::uuid();
		});
	}

	public function travel_agent()
	{
		return $this->belongsTo(User::class, 'travel_agent_id', 'id');
	}
}
