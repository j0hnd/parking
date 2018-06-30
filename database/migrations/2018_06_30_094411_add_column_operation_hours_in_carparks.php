<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOperationHoursInCarparks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('carparks', function($table) {
			$table->time('opening')->after('zipcode');
			$table->time('closing')->after('opening');
			$table->index(['opening', 'closing']);
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
			$table->dropColumn('opening');
			$table->dropColumn('closing');
		});
    }
}
