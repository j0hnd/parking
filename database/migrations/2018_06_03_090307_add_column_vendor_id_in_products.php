<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnVendorIdInProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('products', function($table) {
			$table->integer('vendor_id')->after('revenue_share');
			$table->index('vendor_id');
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
			$table->dropColumn('vendor_id');
		});
    }
}
