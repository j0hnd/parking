<?php

use Illuminate\Database\Seeder;

class PricesAdditionalCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Meet & Greet VIP', 'Meet & Greet Budget'];

        foreach ($categories as $category) {
            DB::table('price_categories')->insert([
                'category_name' => $category,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
