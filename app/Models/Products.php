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
                            if ($no_days <= $price->no_of_days) {
                                $products[] = [
                                    'product_id' => $product->id,
                                    'prices' => $product->prices,
                                    'overrides' => $product->overrides
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
        if (count($products) == 0) {
            return null;
        }

        foreach ($products as $product) {
            dd($product['prices']);
        }
    }
}
