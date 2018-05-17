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

                foreach ($product_airports->get() as $airport) {
                    $product = self::findOrFail($airport->product_id);
                    if (count($product)) {
                        foreach ($product->prices as $price) {
                            if ($no_days == $price->no_of_days) {
                                $products[] = [
                                    'product_id' => $product->id,
									'carpark' => $product->carpark->name,
									'image' => $product->carpark->image,
                                    'prices' => $product->prices,
                                    'overrides' => $product->overrides,
									'services' => $product->carpark_services
                                ];
                            }
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
                foreach ($product['prices'] as $price) {
                    if (empty($price->month) and empty($price->year)) {
                        $category = PriceCategories::findOrFail($price->category_id);
                        $results[$i] = [
                            'product_id' => $product['product_id'],
							'carpark_name' => $product['carpark'],
							'image' => $product['image'],
                            'category' => $category->category_name,
							'price' => $price->price_value
                        ];
                    }
                }

                foreach ($product['services'] as $services) {
                	$carpark_services[] = ['name' => $services->service_name, 'icon' => $services->icon];
				}

				$results[$i]['services'] = $carpark_services;
                unset($carpark_services);

                $i++;
            }
        } catch (\Exception $e) {
            dd($e);
        }

        return $results;
    }
}
