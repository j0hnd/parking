<?php

namespace App\Models;

class Activations extends BaseModel
{
    public function users()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
