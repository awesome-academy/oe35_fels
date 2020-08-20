<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $limit = config('const.seeder.number') + 2;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('profiles')->insert([
                'user_id' => $i + 1,
                'name' => $faker->name,
                'gender' => $faker->randomElement([false, true]),
            ]);
        }
    }
}
