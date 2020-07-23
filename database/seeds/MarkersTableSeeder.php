<?php

use Illuminate\Database\Seeder;

class MarkersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('markers')->insert([
        'project_id' => 1,
        'name' => 'Marker 1',
      ]);

      DB::table('markers')->insert([
        'project_id' => 1,
        'name' => 'Marker 2',
        'active' => 0,
      ]);
    }
}
