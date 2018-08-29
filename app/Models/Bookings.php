<?php

namespace App\Models;

use DB;

class Bookings extends BaseModel
{
	protected $fillable = [
		'booking_id',
		'user_id',
		'product_id',
		'price_id',
		'customer_id',
		'client_first_name',
		'client_last_name',
		'client_email',
		'order_title',
		'price_value',
		'revenue_value',
		'drop_off_at',
		'return_at',
		'flight_no_going',
		'flight_no_return',
		'car_registration_no',
		'vehicle_make',
		'vehicle_model',
		'vehicle_color',
		'sms_confirmation_fee',
		'cancellation_waiver',
		'booking_fees',
		'departure_terminal',
		'arrival_terminal',
		'payment_method'
	];

	protected $dates = ['drop_off_at', 'return_at', 'deleted_at'];

	protected $guarded = ['booking_id'];

	protected $with = ['customers', 'booking_details', 'products', 'affiliate_bookings'];


	public function customers()
	{
		return $this->belongsTo(Customers::class, 'customer_id', 'id');
	}

	public function booking_details()
	{
		return $this->hasOne(BookingDetails::class, 'booking_id', 'id');
	}

	public function products()
	{
		return $this->hasMany(Products::class, "id", "product_id");
	}

	public function affiliate_bookings()
	{
		return $this->hasMany(AffiliateBookings::class, 'booking_id', 'id');
	}

	public static function generate_booking_id($booking_id)
	{
		if (is_null($booking_id) or empty($booking_id) or $booking_id == "") {
			return null;
		}

		$reference_no = str_pad(($booking_id), 6, '0', STR_PAD_LEFT);
		return "MTC-".date('m')."-".$reference_no;
	}

	public static function search($search_str)
	{
		$result = DB::table('bookings')
			->select('bookings.id')
			->join('customers', 'customers.id', '=', 'bookings.customer_id')
			->whereNull('bookings.deleted_at')
			->where(function ($query) use ($search_str) {
				$query->orWhere('bookings.booking_id', 'like', "{$search_str}%");
				$query->orWhere('bookings.order_title', 'like', "{$search_str}%");
				$query->orWhere('bookings.flight_no_going', 'like', "{$search_str}%");
				$query->orWhere('bookings.flight_no_return', 'like', "{$search_str}%");
				$query->orWhere('bookings.vehicle_make', 'like', "{$search_str}%");
				$query->orWhere('bookings.vehicle_model', 'like', "{$search_str}%");
				$query->orWhere('bookings.vehicle_color', 'like', "{$search_str}%");
				$query->orWhere('customers.first_name', 'like', "{$search_str}%");
				$query->orWhere('customers.last_name', 'like', "{$search_str}%");
				$query->orWhere('customers.email', 'like', "{$search_str}%");
				$query->orWhere('bookings.client_first_name', 'like', "{$search_str}%");
				$query->orWhere('bookings.client_last_name', 'like', "{$search_str}%");
			});

		if ($result->count()) {
			foreach ($result->get() as $item) {
				$booking_ids[] = $item->id;
			}
		}

		return isset($booking_ids) ? $booking_ids : null;
	}

	public static function get_user_bookings($company_id)
	{
		$bookings = Bookings::join('products', 'bookings.product_id', 'products.id')
			->join('carparks', 'products.carpark_id', 'carparks.id')
			->where('carparks.company_id', $company_id);

		return $bookings->pluck('booking_id')->toArray();
	}
}
