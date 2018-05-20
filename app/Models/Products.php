<?php

namespace App\Models;

use App\Models\Tools\CarparkServices;
use App\Models\Tools\PriceCategories;
use App\Models\Tools\Prices;
use Carbon\Carbon;

class Products extends BaseModel
{
    protected $fillable = [
        'carpark_id',
        'description',
        'on_arrival',
        'on_return',
        'revenue_share',
        'deleted_at'
    ];

    protected $guarded = ['carpark_id', 'revenue_share'];

    protected $with = ['carpark', 'airport', 'carpark_services', 'prices', 'overrides'];


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

    public static function search($data)
    {
        $products = null;

        try {
            // get airports
            $product_airports = ProductAirports::active()->where(['airport_id' => $data['search']['airport']]);
            if ($product_airports->count()) {

                // get number of days between the dates in the search parameters
                $begin = Carbon::parse($data['search']['drop-off-date']);
                $no_days = $begin->diffInDays($data['search']['return-at-date']);

                if ($no_days === 0) {
                    $no_days = 1;
                }

                $i = 0;

                foreach ($product_airports->get() as $airport) {
                    $product = Products::findOrFail($airport->product_id);
					$override_price = null;

                    if (count($product)) {
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

                        foreach ($product->prices as $price) {
                            if ($no_days === $price->no_of_days and is_null($price->price_month) and is_null($price->price_year)) {
                                $products[$i] = [
                                    'product_id' => $product->id,
									'carpark' => $product->carpark->name,
									'image' => $product->carpark->image,
									'price_id' => $price->id,
                                    'prices' => $price,
									'drop_off' => $data['search']['drop-off-date']." ".$data['search']['drop-off-time'],
									'return_at' => $data['search']['return-at-date']." ".$data['search']['return-at-time'],
                                    'overrides' => $override_price,
									'services' => $product->carpark_services
                                ];
							} elseif ($no_days !== $price->no_of_days and $price->price_month == date('F', strtotime($data['search']['drop-off-date']))) {
								$products[$i] = [
									'product_id' => $product->id,
									'carpark' => $product->carpark->name,
									'image' => $product->carpark->image,
									'price_id' => $price->id,
									'prices' => $price,
									'drop_off' => $data['search']['drop-off-date']." ".$data['search']['drop-off-time'],
									'return_at' => $data['search']['return-at-date']." ".$data['search']['return-at-time'],
									'overrides' => $override_price,
									'services' => $product->carpark_services
								];
							} elseif ($no_days !== $price->no_of_days and $price->price_year == date('Y', strtotime($data['search']['drop-off-date']))) {
								$products[$i] = [
									'product_id' => $product->id,
									'carpark' => $product->carpark->name,
									'image' => $product->carpark->image,
									'price_id' => $price->id,
									'prices' => $price,
									'drop_off' => $data['search']['drop-off-date']." ".$data['search']['drop-off-time'],
									'return_at' => $data['search']['return-at-date']." ".$data['search']['return-at-time'],
									'overrides' => $override_price,
									'services' => $product->carpark_services
								];
							}

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
					'price_id' => $product['price_id'],
					'carpark_name' => $product['carpark'],
					'image' => $product['image'],
					'category' => $category->category_name,
					'price' => is_null($product['overrides']) ? $product['prices']->price_value : ($product['prices']->price_value * $product['overrides']),
					'drop_off' => $product['drop_off'],
					'return_at' => $product['return_at']
				];

                // prepare linked carpark services
                foreach ($product['services'] as $services) {
                	$carpark_services[] = ['name' => $services->service_name, 'icon' => $services->icon];
				}

				$results[$i]['services'] = $carpark_services;
                unset($carpark_services);

                $i++;
            }
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }

        return $results;
    }
}
