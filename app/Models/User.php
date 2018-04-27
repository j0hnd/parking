<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Notifications\Notifiable;
use App\Models\Tools\Roles;
//use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends EloquentUser implements UserInterface
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'permissions', 'last_login', 'is_active', 'remember_token'
    ];

    protected $guarded = ['user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['members', 'roles'];



    public function members()
    {
        return $this->hasOne(Members::class, 'user_id', 'id');
    }

    public function roles() {
        return $this->belongsToMany(Roles::class, 'role_users', 'user_id', 'role_id');
    }
}
