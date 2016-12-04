<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUriFieldToTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tracks', function (Blueprint $table) {
            //
	        $table->string('uri',1000);
        });

	    DB::statement('ALTER TABLE `tracks` MODIFY title VARCHAR(255);');
	    DB::statement('ALTER TABLE `tracks` MODIFY artist VARCHAR(255);');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tracks', function (Blueprint $table) {
            //
	        $table->dropColumn('uri');
        });
    }
}
