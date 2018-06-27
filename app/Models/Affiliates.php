<?php

namespace App\Models;

use Illuminate\Support\Str;
use DB;


class Affiliates extends BaseModel
{
	protected $fillable = ['code', 'travel_agent_id', 'percent_admin', 'percent_vendor', 'percent_travel_agent', 'deleted_at'];

	protected $guarded = ['code'];

	protected $with = ['travel_agent'];


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

	public function bookings()
	{
		return $this->hasMany(AffiliateBookings::class, 'affiliate_id', 'id');
	}

	public static function search($search_str)
	{
		$result = DB::table('affiliates')
			->select('affiliates.id')
			->join('users', 'users.id', '=', 'affiliates.travel_agent_id')
			->join('members', 'members.user_id', '=', 'users.id')
			->whereNull('affiliates.deleted_at')
			->where(function ($query) use ($search_str) {
				$query->orWhere('members.first_name', 'like', "{$search_str}%");
				$query->orWhere('members.last_name', 'like', "{$search_str}%");
				$query->orWhere('affiliates.code', 'like', "{$search_str}%");
			});

		return $result->count() ? $result : null;
	}

	public static function get_id($affiliate_code)
	{
		return DB::table('affiliates')
			->select('id')
			->whereNull('deleted_at')
			->where('code', $affiliate_code)
			->first();
	}
}
