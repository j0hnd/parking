<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnCouponInBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('bookings', function($table) {
			$table->time('coupon')->after('booking_fees')->nullable();
			$table->index('coupon');
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
			$table->dropColumn('coupon');
		});
    }
}
