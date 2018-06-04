<?php

use Illuminate\Database\Seeder;
use App\Models\Carpark;
use App\Models\Airports;
use App\Models\Products;
use App\Models\ProductAirports;
use App\Models\User;
use App\Models\Tools\PriceCategories;
use App\Models\Tools\Prices;
use App\Models\Tools\CarparkServices;
use App\Models\Services;


class FakeProducts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	try {
			$faker = Faker\Factory::create();

			$limit = 10;

			DB::beginTransaction();

			for ($i = 0; $i <= $limit; $i++) {
				$carpark = Carpark::active()->inRandomOrder()->first();
				$airport = Airports::active()->inRandomOrder()->first();
				$vendor  = User::active()->whereHas('roles', function ($query) {
					$query->where('slug', 'vendor');
				})
					->inRandomOrder()
					->first();

				$product = Products::create([
					'carpark_id' => $carpark->id,
					'vendor_id' => $vendor->id,
					'description' => $faker->text,
					'on_arrival' => $faker->text,
					'on_return' => $faker->text,
					'revenue_share' => rand(3, 25)
				]);

				if ($product) {
					ProductAirports::create([
						'product_id' => $product->id,
						'airport_id' => $airport->id
					]);

					for ($_i = 0; $_i <= rand(2, 5); $_i++) {
						$category = PriceCategories::active()->inRandomOrder()->first();
						Prices::create([
							'category_id' => $category->id,
							'product_id' => $product->id,
							'no_of_days' => rand(2, 10),
							'price_value' => mt_rand() / mt_getrandmax()
						]);
					}

					for ($_i = 0; $_i <= rand(2, 5); $_i++) {
						$category = PriceCategories::active()->inRandomOrder()->first();
						Prices::create([
							'category_id' => $category->id,
							'product_id' => $product->id,
							'price_month' => rand(1, 12),
							'price_year' => rand(date('Y'), date('Y') + 5),
							'price_value' => mt_rand() / mt_getrandmax()
						]);
					}

					$carpark_services = CarparkServices::active()->inRandomOrder()->take(5)->get();
					foreach ($carpark_services as $carpark_svc) {
						Services::create([
							'product_id' => $product->id,
							'service_id' => $carpark_svc->id
						]);
					}

					DB::commit();
				}
			}

			$this->command->info("Created products.");
			$this->command->info("Completed!");
		} catch (Exception $e) {
    		DB::rollback();
    		$this->command->error($e->getMessage());
		}

    }
}
