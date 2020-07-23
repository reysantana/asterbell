<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('submission_id')->unsigned();
          $table->integer('notification_template_id')->unsigned();
          $table->integer('user_id')->unsigned();
          $table->boolean('deleted')->default(0);
          $table->timestamp('created_at')->useCurrent();
          $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

          $table->foreign('submission_id')->references('id')->on('submissions');
          $table->foreign('notification_template_id')->references('id')->on('notification_templates');
          $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
