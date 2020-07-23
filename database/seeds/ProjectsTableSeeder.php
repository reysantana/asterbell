<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('projects')->insert([
        'name' => 'Election 2018',
        'slug' => 'election-2018',
        'start_date' => '2018-01-01 00:00:00',
        'end_date' => '2018-05-01 23:59:59',
      ]);
    }
}
