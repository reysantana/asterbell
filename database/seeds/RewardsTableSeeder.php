<?php

use Illuminate\Database\Seeder;

class RewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('rewards')->insert([
        'marker_id' => 1,
        'notification_template_id' => 2,
        'name' => 'Reward 1',
        'serial_code' => 'RWD0001',
      ]);

      DB::table('rewards')->insert([
        'marker_id' => 2,
        'notification_template_id' => 2,
        'name' => 'Reward 2',
        'serial_code' => 'RWD0002',
      ]);
    }
}
