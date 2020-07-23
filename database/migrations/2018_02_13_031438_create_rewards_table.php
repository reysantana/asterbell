<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewards', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('marker_id')->unsigned();
          $table->integer('notification_template_id')->unsigned();
          $table->string('name');
          $table->string('serial_code', 10);
          $table->text('image_path')->nullable();
          $table->boolean('active')->default(1);          
          $table->timestamp('created_at')->useCurrent();
          $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

          $table->foreign('marker_id')->references('id')->on('markers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rewards');
    }
}
