<?php

use Illuminate\Database\Seeder;
use App\Models\Customers;


class FakeCustomers extends Seeder
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

			$limit = 50;

			for ($i = 0; $i < $limit; $i++) {
				$firstname = $faker->firstName();
				$lastname = $faker->lastName();
				$email = strtolower($firstname).".".strtolower($lastname)."@".$faker->safeEmailDomain();

				Customers::create([
					'first_name' => $firstname,
					'last_name' => $lastname,
					'email' => $email,
					'mobile_no' => $faker->e164PhoneNumber()
				]);
			}

			$this->command->info("{$limit} customers has been created.");

		} catch (Exception $e) {
    		$this->command->error($e->getMessage());
		}
    }
}
