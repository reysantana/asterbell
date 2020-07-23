<?php

use Illuminate\Database\Seeder;

class NotificationTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('notification_templates')->insert([
        'id' => 1,
        'title' => 'For Quest Reward',
        'category' => 'reward',
        'message_excerpt' => 'Congratulations! Here\' your reward for completing the quest.',
        'message_content' => 'Congratulations! Here\' your reward for completing the quest. Please present it to our crew to claim the reward. Serial Code: {{SERIAL_CODE}}',
      ]);

      DB::table('notification_templates')->insert([
        'id' => 2,
        'title' => 'For Exclusive Reward',
        'category' => 'reward',
        'message_excerpt' => 'Thank you for sharing your thought. You\'ve won an exclusive reward.',
        'message_content' => 'Thank you for sharing your thought. You\'ve won an exclusive reward. Please present it to our crew to claim the reward. Serial Code: {{SERIAL_CODE}}',
      ]);

      DB::table('notification_templates')->insert([
        'id' => 3,
        'title' => 'Admin Added New Message',
        'category' => 'message',
        'message_excerpt' => 'You\'ve received a new message!',
      ]);
    }
}
