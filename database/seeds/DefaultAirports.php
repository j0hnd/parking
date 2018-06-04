<?php

use Illuminate\Database\Seeder;
use App\Models\Airports;

class DefaultAirports extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $airports = [
        	[
        		'airport_name' => 'London City Airport',
				'airport_code' => 'LCY',
				'address' => 'Hartmann Rd',
				'city' => 'Silvertown',
				'county_state' => 'London',
				'zipcode' => 'E16 2PX',
				'country_id' => 249
			],
        	[
        		'airport_name' => 'Heathrow Airport',
				'airport_code' => 'LHR',
				'address' => 'Longford',
				'city' => 'London Borough of Hillingdon',
				'county_state' => 'London',
				'zipcode' => '',
				'country_id' => 249
			],
        	[
        		'airport_name' => 'Gatwick Airport',
				'airport_code' => 'LGW',
				'address' => 'Horley',
				'city' => 'Crawley',
				'county_state' => 'Gatwick',
				'zipcode' => 'RH6 0NP',
				'country_id' => 249
			],
        	[
        		'airport_name' => 'Luton Airport',
				'airport_code' => 'LTN',
				'address' => 'Airport Way',
				'city' => 'Luton',
				'county_state' => 'Bedfordshire',
				'zipcode' => 'LU2 9LY',
				'country_id' => 249
			],
        	[
        		'airport_name' => 'London Stansted Airport',
				'airport_code' => 'STN',
				'address' => 'Bassingbourn Rd',
				'city' => 'Stansed',
				'county_state' => 'Essex',
				'zipcode' => 'CM24 1QW',
				'country_id' => 249
			],
        	[
        		'airport_name' => 'London Southend Airport',
				'airport_code' => 'SEN',
				'address' => 'Southend-on-Sea',
				'city' => 'Southend',
				'county_state' => 'Essex',
				'zipcode' => 'SS2 6YF',
				'country_id' => 249
			],
		];

        try {
			Airports::truncate();

			foreach ($airports as $airport) {
				$response = Airports::create($airport);
				if ($response) {
					$this->command->info("Added " . $response->airport_name);
				}
			}

			$this->command->info("Completed!");
		} catch (Exception $e) {
        	$this->command->error($e->getMessage());
			$this->command->info("Interrupted!");
		}
    }
}
