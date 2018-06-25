<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUserIdInBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('bookings', function($table) {
			$table->bigInteger('user_id')->default(0)->after('booking_id');
			$table->index('user_id');
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
			$table->dropColumn('user_id');
		});
    }
}
