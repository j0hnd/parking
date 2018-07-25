<?php

namespace App\Models;

use App\Models\Tools\CarparkServices;
use App\Models\Tools\PriceCategories;
use App\Models\Tools\Prices;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;


class Products extends BaseModel
{
    protected $fillable = [
        'carpark_id',
		'short_descrption',
        'description',
        'on_arrival',
        'on_return',
        'directions',
        'revenue_share',
        'deleted_at'
    ];

    protected $guarded = ['carpark_id', 'revenue_share'];

    protected $with = ['carpark', 'airport', 'carpark_services', 'prices', 'overrides', 'vendors'];


    public function carpark()
    {
        return $this->hasOne(Carpark::class, 'id', 'carpark_id');
    }

    public function airport()
    {
        return $this->belongsToMany(Airports::class, 'product_airports', 'product_id', 'airport_id')->whereNull('product_airports.deleted_at');
    }

    public function carpark_services()
    {
        return $this->belongsToMany(CarparkServices::class, 'services', 'product_id', 'service_id')->whereNull('services.deleted_at');
    }

    public function prices()
    {
        return $this->hasMany(Prices::class, 'product_id', 'id');
    }

    public function overrides()
    {
        return $this->hasMany(Overrides::class, 'product_id', 'id');
    }

    public function vendors()
	{
		return $this->hasMany(Companies::class, 'id', 'vendor_id');
	}

    public static function search($data)
    {
        $products = null;

        try {
			$today = Carbon::now();
			$begin = Carbon::createFromFormat('d/m/Y', $data['search']['drop-off-date']);
			$end   = Carbon::createFromFormat('d/m/Y', $data['search']['return-at-date']);

            // get number of days between the dates in the search parameters
			$no_days = $begin->diffInDays($end);

			if ($no_days === 0) {
				$no_days = 1;
			}

			// get airports
			$product_airports = ProductAirports::selectRaw("product_airports.product_id, product_airports.airport_id, prices.id AS price_id, carparks.no_bookings_not_less_than_24hrs")
				->join('products', 'products.id', '=', 'product_airports.product_id')
				->join('airports', 'airports.id', '=', 'product_airports.airport_id')
				->join('carparks', 'carparks.id', '=', 'products.carpark_id')
				->join('prices', 'prices.product_id', '=', 'products.id')
				->join('price_categories', 'price_categories.id', '=', 'prices.category_id')
				->whereNull('product_airports.deleted_at')
				->where(['airport_id' => $data['search']['airport']])
				->whereNull('products.deleted_at')
				->whereNull('carparks.deleted_at')
				->whereNull('airports.deleted_at')
//				->whereRaw("(prices.no_of_days = ? AND prices.price_month IS NULL AND prices.price_year IS NULL)", [$no_days])
//				->orWhereRaw("(prices.no_of_days = ? AND prices.price_month = ? AND prices.price_year IS NULL)", [$no_days, date('n')])
//				->orWhereRaw("(prices.no_of_days = ? AND prices.price_month IS NULL AND prices.price_year = ?)", [$no_days, date('Y')])
//				->orWhereRaw("(prices.no_of_days = ? AND prices.price_month = ? AND prices.price_year = ?)", [$no_days, date('n'), date('Y')])
//				->groupBy('prices.id');

				->whereRaw("(carparks.is_24hrs_svc = 1 OR (TIME('".$data['search']['drop-off-time']."') BETWEEN opening AND closing AND TIME('".$data['search']['return-at-time']."') BETWEEN opening AND closing))")
//				->whereRaw("(prices.no_of_days = ? OR prices.price_month = ? OR prices.price_year = ?)", [$no_days, date('m'), date('Y')]);
				->where('prices.no_of_days', $no_days);

        	if (isset($data['sub'])) {
				if ($data['sub']['type'] == 'service') {
					$service_name = urldecode($data['sub']['value']);
					$product_airports = ProductAirports::selectRaw("product_airports.product_id, product_airports.airport_id, prices.id AS price_id, carparks.no_bookings_not_less_than_24hrs")
						->join('products', 'products.id', '=', 'product_airports.product_id')
						->join('airports', 'airports.id', '=', 'product_airports.airport_id')
						->join('carparks', 'carparks.id', '=', 'products.carpark_id')
						->join('services', 'services.product_id', '=', 'products.id')
						->join('carpark_services', 'carpark_services.id', '=', 'services.service_id')
						->join('prices', 'prices.product_id', '=', 'products.id')
						->whereNull('product_airports.deleted_at')
						->whereNull('products.deleted_at')
						->whereNull('carparks.deleted_at')
						->whereNull('airports.deleted_at')
						->where('airport_id', $data['search']['airport'])
						->where('carpark_services.service_name', $service_name)
						->where('prices.no_of_days', $no_days)
						->whereRaw("(carparks.is_24hrs_svc = 1 OR (TIME('".$data['search']['drop-off-time']."') BETWEEN opening AND closing AND TIME('".$data['search']['return-at-time']."') BETWEEN opening AND closing))");
				}

				if ($data['sub']['type'] == 'price') {
					list($price_from, $price_to) = explode('-', $data['sub']['value']);
					$price_to = $price_to == 'Up' ? 5000 : $price_to;

					$product_airports = ProductAirports::selectRaw("product_airports.product_id, product_airports.airport_id, prices.id AS price_id, carparks.no_bookings_not_less_than_24hrs")
						->join('products', 'products.id', '=', 'product_airports.product_id')
						->join('airports', 'airports.id', '=', 'product_airports.airport_id')
						->join('carparks', 'carparks.id', '=', 'products.carpark_id')
						->join('prices', 'prices.product_id', '=', 'products.id')
						->join('price_categories', 'price_categories.id', '=', 'prices.category_id')
						->whereNull('product_airports.deleted_at')
						->whereNull('products.deleted_at')
						->whereNull('carparks.deleted_at')
						->whereNull('airports.deleted_at')
						->where('prices.no_of_days', $no_days)
						->whereRaw("(carparks.is_24hrs_svc = 1 OR (TIME('".$data['search']['drop-off-time']."') BETWEEN opening AND closing AND TIME('".$data['search']['return-at-time']."') BETWEEN opening AND closing))")
						->where([
							'product_airports.airport_id' => $data['search']['airport']
						])
					    ->whereRaw("prices.price_value >= ? AND prices.price_value <= ?", [$price_from, $price_to]);
				}
			}

			if (isset($data['filter'])) {
				if ($data['filter'] != 'all') {
					switch ($data['filter']) {
						case "onsite":
							$category_id = 1;
							break;
						case "offsite":
							$category_id = 2;
							break;
						case "parkride":
							$category_id = 3;
							break;
						case "meetgreet":
							$category_id = 4;
							break;
					}

					// get airports
					$product_airports = ProductAirports::selectRaw("product_airports.airport_id, product_airports.product_id, prices.category_id, prices.id as price_id, carparks.no_bookings_not_less_than_24hrs")
						->join('products', 'products.id', '=', 'product_airports.product_id')
						->join('airports', 'airports.id', '=', 'product_airports.airport_id')
						->join('carparks', 'carparks.id', '=', 'products.carpark_id')
						->join('prices', 'prices.product_id', '=', 'products.id')
						->join('price_categories', 'price_categories.id', '=', 'prices.category_id')
						->whereNull('product_airports.deleted_at')
						->whereNull('products.deleted_at')
						->whereNull('carparks.deleted_at')
						->whereNull('airports.deleted_at')
						->where('prices.no_of_days', $no_days)
						->whereRaw("(carparks.is_24hrs_svc = 1 OR (TIME('".$data['search']['drop-off-time']."') BETWEEN opening AND closing AND TIME('".$data['search']['return-at-time']."') BETWEEN opening AND closing))")
//						->whereRaw("(prices.no_of_days = ? AND prices.price_month IS NULL AND prices.price_year IS NULL)", [$no_days])
//						->orWhereRaw("(prices.no_of_days = ? AND prices.price_month = ? AND prices.price_year IS NULL)", [$no_days, date('n')])
//						->orWhereRaw("(prices.no_of_days = ? AND prices.price_month IS NULL AND prices.price_year = ?)", [$no_days, date('Y')])
//						->orWhereRaw("(prices.no_of_days = ? AND prices.price_month = ? AND prices.price_year = ?)", [$no_days, date('n'), date('Y')])
						->where([
							'product_airports.airport_id' => $data['search']['airport'],
							'prices.category_id' => $category_id
						]);
				}
			}

            if ($product_airports->count()) {
                $i = 0;

                foreach ($product_airports->get() as $pa) {
                    if ($pa->no_bookings_not_less_than_24hrs == 1) {
                        $drop_off  = $begin->format('Y-m-d').' '.$data['search']['drop-off-time'].':00';
                        $drop_off  = Carbon::createFromFormat('Y-m-d H:i:s', $drop_off);
                        $time_diff = $drop_off->diffInHours($today);

                        if ($time_diff <= 24) {
                            break;
                        }
                    }

					$override_price = null;
					$product = Products::findOrFail($pa->product_id);
					$airport = Airports::findOrFail($pa->airport_id);

                    if (count($product) > 0) {
						if (isset($pa->price_id)) {
							$prices = Prices::whereNull('deleted_at')->where('id', $pa->price_id)->get();
						} else {
							$prices = $product->prices;
						}

						// check for overrides
						if (count($product->overrides)) {
							foreach ($product->overrides as $overrides) {
								list($begin, $end) = explode(' - ', $overrides->override_dates);
								$begin = new Carbon($begin);
								$end = new Carbon($end);

								if (strtotime($data['search']['drop-off-date']) >= strtotime($begin) and strtotime($data['search']['return-at-date']) <= strtotime($end)) {
									$override_price = $overrides->override_price * $no_days;
								}
							}
						}

                        foreach ($prices as $price) {
                                $products[$i] = [
                                    'product_id' => $product->id,
									'airport_id' => $pa->airport_id,
									'airport_name' => $airport->airport_name,
									'carpark' => $product->carpark->name,
									'image' => $product->carpark->image,
									'price_id' => $price->id,
                                    'prices' => $price,
									'drop_off' => $data['search']['drop-off-date']." ".$data['search']['drop-off-time'],
									'return_at' => $data['search']['return-at-date']." ".$data['search']['return-at-time'],
                                    'overrides' => $override_price,
									'services' => $product->carpark_services,
									'short_description' => $product->short_description,
									'description' => $product->description,
									'on_arrival' => $product->on_arrival,
									'on_return' => $product->on_return,
									'latitude' => $airport->latitude,
									'longitude' => $airport->longitude
                                ];

							$i++;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        return $products;
    }

    public static function prepare_data($products)
    {
        try {
            if (count($products) == 0) {
                return null;
            }

			$i = 0;

            foreach ($products as $product) {
            	// prepare prices
				$price = $product['prices'];
				$category = PriceCategories::findOrFail($price->category_id);

				$results[$i] = [
					'product_id' => $product['product_id'],
					'airport_id' => $product['airport_id'],
					'airport_name' => $product['airport_name'],
					'price_id' => $product['price_id'],
					'carpark_name' => $product['carpark'],
					'image' => $product['image'],
					'category' => $category->category_name,
					'price' => (is_null($product['overrides']) or $product['overrides'] == 0) ? $product['prices']->price_value : $product['prices']->price_value * $product['overrides'],
					'drop_off' => $product['drop_off'],
					'return_at' => $product['return_at'],
					'short_description' => $product['short_description'],
					'description' => $product['description'],
					'on_arrival' => $product['on_arrival'],
					'on_return' => $product['on_return'],
					'latitude' => $product['latitude'],
					'longitude' => $product['longitude']
				];

                // prepare linked carpark services
                foreach ($product['services'] as $services) {
                	$carpark_services[] = ['name' => $services->service_name, 'icon' => $services->icon];
				}

				$results[$i]['services'] = $carpark_services;
				$carpark_services = null;

                $i++;
            }
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        return $results;
    }
}
