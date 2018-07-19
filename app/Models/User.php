<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Notifications\Notifiable;
use App\Models\Tools\Roles;
use DB;
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
        'email', 'password', 'permissions', 'last_login', 'is_active', 'remember_token', 'deleted_at'
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

    protected $with = ['members', 'roles', 'affiliate', 'activations'];


    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function members()
    {
        return $this->hasOne(Members::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'role_users', 'user_id', 'role_id');
    }

    public function affiliate()
	{
		return $this->hasOne(Affiliates::class, 'id', 'travel_agent_id');
	}

	public function activations()
	{
		return $this->hasOne(Activations::class, 'user_id', 'id');
	}

    public static function search($search_str)
    {
        $results = DB::table('users')
            ->select('users.id')
            ->join('members', 'members.user_id', '=', 'users.id')
            ->whereNull('users.deleted_at')
            ->whereNull('members.deleted_at')
            ->where(function ($query) use ($search_str) {
                $query->orWhere('users.email', 'like', "{$search_str}%");
                $query->orWhere('members.first_name', 'like', "{$search_str}%");
                $query->orWhere('members.last_name', 'like', "{$search_str}%");
            });

        $data = $ids = [];

        if ($results->count()) {
            foreach ($results->get() as $result) {
                $ids[] = $result->id;
            }

            $data = User::whereIn('id', $ids);
        }

        return count($data) ? $data : null;
    }
}
