<?php

namespace App\Models\Tools;

use App\Models\BaseModel;
use Webpatser\Uuid\Uuid;


class Sessions extends BaseModel
{
    protected $guarded = ['session_id', 'booking_id', 'requests'];

    protected $fillable = ['request_id', 'booking_id', 'requests', 'response'];


	public static function boot()
	{
		parent::boot();

		self::creating(function ($model) {
			$model->session_id = Uuid::generate()->string;
		});
	}
}
