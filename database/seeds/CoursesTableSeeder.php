<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
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

        for ($i=0; $i < $limit; $i++) {
            DB::table('courses')->insert([
                'name' => $faker->word,
                'description' => $faker->sentence(3),
            ]);
        }
    }
}
