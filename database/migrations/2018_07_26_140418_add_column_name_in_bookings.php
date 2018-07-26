<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNameInBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function($table) {
			$table->string('client_first_name', 40)->after('price_id')->nullable();
			$table->string('client_last_name', 40)->after('client_first_name')->nullable();
			$table->string('client_email', 200)->after('client_last_name')->nullable();
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
            $table->dropColumn('client_first_name');
            $table->dropColumn('client_last_name');
            $table->dropColumn('client_email');
        });
    }
}
