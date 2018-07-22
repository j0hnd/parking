<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNoBookingsNotLessThan24hrsInCarparks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('carparks', function($table) {
			$table->integer('no_bookings_not_less_than_24hrs')->after('is_24hrs_svc')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('carparks', function (Blueprint $table) {
			$table->dropColumn('no_bookings_not_less_than_24hrs');
		});
    }
}
