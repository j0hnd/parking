<?php

use Illuminate\Database\Seeder;
use App\Models\Tools\PriceCategories;


class PriceCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceCategories::truncate();
        $categories = ['Onsite', 'Offsite', 'Park and Ride', 'Meet and Greet'];

        foreach ($categories as $category) {
            DB::table('price_categories')->insert([
                'category_name' => $category,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
