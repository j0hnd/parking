<?php

use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ['Security Cams', 'Entry Barriers', 'Indoor', 'Outdoor', 'Insured', 'Car wash', 'Valet', 'Shuttle Bus Charged', 'Shuttle Bus Free', 'Carpark Fees'];

        foreach ($services as $service) {
            DB::table('carpark_services')->insert([
                'service_name' => $service,
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
