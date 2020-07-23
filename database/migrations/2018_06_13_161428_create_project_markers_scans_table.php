<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMarkersScansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_markers_scans', function (Blueprint $table) {
              $table->increments('id');
              $table->integer('project_marker_id')->unsigned();
              $table->integer('user_id')->unsigned();
              $table->boolean('completed')->default(0);
              $table->timestamp('created_at')->useCurrent();
              $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

              $table->foreign('project_marker_id')->references('id')->on('project_markers');
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
        Schema::dropIfExists('project_markers_scans');
    }
}
