<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $fillable = ['user_id', 'first_name', 'last_name'];

    protected $guarded  = ['user_id'];

    protected $dates    = ['deleted_at', 'created_at', 'updated_at'];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
