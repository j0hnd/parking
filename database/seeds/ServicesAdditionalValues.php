<?php

use Illuminate\Database\Seeder;

class ServicesAdditionalValues extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ["Suitable for large Equipment / Sport", 'Disable Friendly'];
        $icons    = ['fa-random', 'fa-wheelchair'];

        foreach ($services as $i => $service) {
            DB::table('carpark_services')->insert([
                'service_name' => $service,
                'icon'         => $icons[$i],
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
