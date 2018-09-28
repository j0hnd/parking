<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PriceHistory extends BaseModel
{
	use SoftDeletes;

    protected $fillable = ['price_id', 'no_of_days', 'price_month', 'price_year', 'price_value', 'changed_by', 'approved_at', 'approved_by', 'deleted_at'];

    protected $guarded = ['price_id', 'no_of_days', 'price_month', 'price_year', 'price_value'];

    protected $dates = ['approved_at', 'deleted_at'];


    public static function get_requests()
	{
		return PriceHistory::selectRaw("
						price_histories.id,
						prices.id as price_id,
						CONCAT(airports.airport_name,'-',price_categories.category_name) AS order_title,
						prices.no_of_days, 
						prices.price_month, 
						prices.price_year, 
						prices.price_value, 
						price_histories.no_of_days AS request_no_of_days, 
						price_histories.price_month AS request_price_month, 
						price_histories.price_year AS request_price_year, 
						price_histories.price_value AS request_price_value")
			->join('prices', 'prices.id', '=', 'price_histories.price_id')
			->join('products', 'products.id', '=', 'prices.product_id')
			->join('carparks', 'carparks.id', '=', 'products.carpark_id')
			->join('price_categories', 'price_categories.id', '=', 'prices.category_id')
			->join('product_airports', 'product_airports.product_id', '=', 'products.id')
			->join('airports', 'airports.id', '=', 'product_airports.airport_id')
			->whereNull('price_histories.approved_at')
			->whereNull('price_histories.deleted_at')
			->whereNull('prices.deleted_at');
	}
}
