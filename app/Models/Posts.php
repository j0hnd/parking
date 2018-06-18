<?php

namespace App\Models;


class Posts extends BaseModel
{
    protected $fillable = ['title', 'slug', 'content', 'image', 'status', 'created_by', 'date_published', 'deleted_at'];

    protected $guarded = ['created_by'];

    protected $with = ['owner'];

    protected $date = ['date_published', 'deleted_at'];


    public function owner()
	{
		return $this->hasMany(User::class, 'id', 'created_by');
	}
}
