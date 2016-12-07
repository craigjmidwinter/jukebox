<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QueueTracking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('queues', function (Blueprint $table) {

		    $table->increments('id');
		    $table->unsignedInteger('track_id');
		    $table->unsignedInteger('queue_time');
		    $table->unsignedInteger('queue_type');
	    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //

	    Schema::drop('queues');
    }
}
