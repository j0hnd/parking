<?php

use Illuminate\Database\Seeder;
use App\Models\Tools\Roles;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::truncate();

        $roles = [
            [
                'slug'=>'administrator',
                'name'=>'Administrator',
                'permissions'=>[
                    'all'=>true
                ]
            ],
            [
                "slug"=>'vendor',
                "name"=>'Vendor',
                "permissions"=>[
                    "airport.destroy"=>false,
                    "carpark.destroy"=>false,
                    "products.destroy"=>false,
                ]
            ],
            [
                "slug"=>'travel_agent',
                "name"=>'Travel Agent',
                "permissions"=>[
                    "airport.destroy"=>false,
                    "carpark.destroy"=>false,
                    "products.destroy"=>false,
                ]
            ],
            [
                "slug"=>'member',
                "name"=>'Member',
                "permissions"=>[
                    "airport.destroy"=>false,
                    "carpark.destroy"=>false,
                    "products.destroy"=>false,
                ]
            ]
        ];

        \Illuminate\Database\Eloquent\Model::unguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($roles as $value) {
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'slug'=>$value['slug'],
                'name'=>$value['name'],
                'permissions'=>(is_array($value['permissions'])) ? $value['permissions'] : null
            ]);
        }

        \Illuminate\Database\Eloquent\Model::reguard();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
