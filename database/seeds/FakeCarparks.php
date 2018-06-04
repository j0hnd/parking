<?php

use Illuminate\Database\Seeder;
use App\Models\Carpark;
use App\Models\Companies;

class FakeCarparks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	try {
			Carpark::truncate();

			$faker = Faker\Factory::create();

			$company_limit = 10;
			$carpark_limit = 3;

			$city = ['Silvertown', 'Longford', 'Crawley', 'Luton', 'Stansed', 'Southend'];
			$county = ['London', 'Hounslow', 'Gatwick', 'Bedfordshire', 'Essex', 'Essex'];

			DB::beginTransaction();

			for ($i = 0; $i <= $company_limit; $i++) {
				$firstname = $faker->firstName;
				$lastnam = $faker->lastName;
				$email = strtolower($firstname).".".strtolower($lastnam)."@example.com";
				$company = $faker->company;
				$company_email = explode(" ", $company);
				$company_email = trim($company_email[0], ".");
				$company_email = trim($company_email, ",");
				$company_email = strtolower($company_email)."@example.com";

				$company = Companies::create([
					'company_name' => $company,
					'phone_no' => $faker->e164PhoneNumber,
					'mobile_no' => $faker->e164PhoneNumber,
					'email' => $company_email,
					'poc_name' => "{$firstname} {$lastnam}",
					'poc_contact_email' => $email
				]);

				if ($company) {
					$this->command->info('Company '.$company->company_name . ' has been added');
					for ($x = 0; $x <= $carpark_limit; $x++) {

						$_i = rand(0, 5);

						$carpark = Carpark::create([
							'company_id' => $company->id,
							'name' => $faker->firstName().'-'.$faker->randomLetter()." Parking",
							'address' => $faker->streetAddress,
							'city' => $city[$_i],
							'county_state' => $county[$_i],
							'country_id' => 249
						]);

						if ($carpark) {
							$this->command->info("Carpark " . $carpark->name . " has been added");
						}
					}
				}
			}

			DB::commit();

			$this->command->info("Completed");
		} catch (Exception $e) {
    		DB::rollback();
    		$this->command->error($e->getMessage());
		}
    }
}
