<?php

namespace App\Models;


class Posts extends BaseModel
{
    protected $fillable = ['title', 'content', 'image'];

    protected $guarded = ['created_by'];

    protected $with = ['owner'];


    public function owner()
	{
		return $this->hasMany(User::class, 'created_by', 'id');
	}
}
