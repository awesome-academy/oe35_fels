<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $limit = config('const.seeder.number');

        // create Super Admin & Admin account
        DB::table('users')->insert([
            [
                'role_id' => 1,
                'email' => 'superadmin@mail.com',
                'password' => bcrypt('123456'),
            ],
            [
                'role_id' => 2,
                'email' => 'admin@mail.com',
                'password' => bcrypt('123456'),
            ],
        ]);

        // create random user account
        for ($i=0; $i < $limit; $i++) {
            DB::table('users')->insert([
                'role_id' => 3,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('123456'),
            ]);
        }
    }
}
