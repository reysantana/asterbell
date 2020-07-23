<?php

use Illuminate\Database\Seeder;

class SurveysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('surveys')->insert([
        'marker_id' => 1,
        'question' => 'Survey question 1',
      ]);

      DB::table('surveys')->insert([
        'marker_id' => 2,
        'question' => 'Survey question 2',
        'active' => 0,
      ]);
    }
}
