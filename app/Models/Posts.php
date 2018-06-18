<?php

namespace App\Models;


class Posts extends BaseModel
{
    protected $fillable = ['title', 'slug', 'content', 'image', 'status', 'date_published'];

    protected $guarded = ['created_by'];

    protected $with = ['owner'];


    public function owner()
	{
		return $this->hasMany(User::class, 'id', 'created_by');
	}
}
