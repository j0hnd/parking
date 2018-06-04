<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Members;
use App\Models\Companies;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        Members::truncate();
        Companies::truncate();

        DB::table('role_users')->truncate();

        $user = Sentinel::registerAndActivate([
            'email' => 'admin@parkingapp.com',
            'password' => "p@rk1ng"
        ]);

		$this->command->info("User admin@parkingapp.com has been added");

        DB::table('role_users')->insert(['user_id' => $user->id, 'role_id' => 1]);

        Members::create([
            'user_id'    => $user->id,
            'first_name' => 'John',
            'last_name'  => 'Smith',
            'is_active'  => 1
        ]);


        $user = Sentinel::registerAndActivate([
            'email' => 'vendor@parkingapp.com',
            'password' => "p@rk1ng"
        ]);

        $this->command->info("User vendor@parkingapp.com has been added");

        DB::table('role_users')->insert(['user_id' => $user->id, 'role_id' => 2]);

        $company = Companies::create([
        	'company_name' => 'Vendor Ltd.',
			'email'        => 'parkingapp@example.com'
		]);

        Members::create([
            'user_id'    => $user->id,
            'company_id' => $company->id,
            'first_name' => 'Jane',
            'last_name'  => 'Doe',
            'is_active'  => 1
        ]);


        $user = Sentinel::registerAndActivate([
            'email' => 'travelagent@parkingapp.com',
            'password' => "p@rk1ng"
        ]);

		$this->command->info("User travelagent@parkingapp.com has been added");

        DB::table('role_users')->insert(['user_id' => $user->id, 'role_id' => 3]);

        Members::create([
            'user_id'    => $user->id,
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'is_active'  => 1
        ]);

        $user = Sentinel::registerAndActivate([
            'email' => 'member@parkingapp.com',
            'password' => "p@rk1ng"
        ]);

		$this->command->info("User member@parkingapp.com has been added");

        DB::table('role_users')->insert(['user_id' => $user->id, 'role_id' => 4]);

        Members::create([
            'user_id'    => $user->id,
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'is_active'  => 1
        ]);
    }
}
