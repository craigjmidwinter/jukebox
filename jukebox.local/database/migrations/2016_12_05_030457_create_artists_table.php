<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

	    Schema::create('artists', function (Blueprint $table) {

		    $table->increments('id');
		    $table->string('name');
	    });

	    Schema::table('tracks', function (Blueprint $table) {

		    $table->dropColumn('artist');
		    $table->unsignedInteger('artist_id');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('artists');

	    Schema::table('tracks', function (Blueprint $table) {
		    $table->dropColumn('artist_id');
		    $table->string('artist')->nullable();
	    });
    }
}
