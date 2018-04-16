<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = ['Standard Parking', 'VIP', 'Meet & Greet', 'On Airport', 'Off Airport'];

        foreach ($products as $product) {
            DB::table('aps_product_types')->insert([
                'product_type_name' => $product,
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
