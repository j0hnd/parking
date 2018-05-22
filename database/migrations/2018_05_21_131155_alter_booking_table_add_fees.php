<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBookingTableAddFees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('bookings', function($table) {
			$table->float('sms_confirmation_fee')->after('revenue_value')->nullable();
			$table->float('cancellation_waiver')->after('sms_confirmation_fee')->nullable();
			$table->float('booking_fees')->after('cancellation_waiver')->nullable();
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
			$table->dropColumn('sms_confirmation_fee');
			$table->dropColumn('cancellation_waiver');
			$table->dropColumn('booking_fees');
		});
    }
}
