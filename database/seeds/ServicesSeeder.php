<?php

use Illuminate\Database\Seeder;
use App\Models\Tools\CarparkServices;


class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarparkServices::truncate();
        $services = ['Security Cams', 'Entry Barriers', 'Indoor', 'Outdoor', 'Insured', 'Car wash', 'Valet', 'Shuttle Bus Charged', 'Shuttle Bus Free', 'Carpark Fees'];
        $icons    = ['fa-video-camera', 'fa-bars', ' fa-indent', 'fa-dedent', 'fa-lock', 'fa-car', 'fa-car', 'fa-bus', 'fa-bus', 'fa-gbp'];

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
