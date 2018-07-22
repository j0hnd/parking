<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTerminalInBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function($table) {
			$table->integer('departure_terminal')->after('flight_no_going')->nullable();
			$table->integer('arrival_terminal')->after('flight_no_return')->nullable();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
			$table->dropColumn('departure_terminal');
			$table->dropColumn('arrival_terminal');
		});
    }
}
