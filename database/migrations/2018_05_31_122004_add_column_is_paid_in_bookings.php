<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsPaidInBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('bookings', function($table) {
			$table->tinyInteger('is_paid')->default(0)->after('vehicle_color');
			$table->datetime('paid_at')->nullable()->after('is_paid');
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
			$table->dropColumn('is_paid');
			$table->dropColumn('paid_at');
		});
    }
}
