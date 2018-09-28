<?php

namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

class Posts extends BaseModel
{
	use SoftDeletes;

    protected $fillable = ['title', 'slug', 'content', 'image', 'status', 'created_by', 'date_published', 'deleted_at'];

    protected $guarded = ['created_by'];

    protected $with = ['owner'];

    protected $date = ['date_published', 'deleted_at'];


    public function scopePublished($query)
	{
		return $query->where('status', 'published');
	}

    public function owner()
	{
		return $this->hasMany(User::class, 'id', 'created_by');
	}
}
