<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumn24hrsServiceInCarparks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('carparks', function($table) {
			$table->tinyInteger('is_24hrs_svc')->after('zipcode')->default(1);
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
			$table->dropColumn('is_24hrs_svc');
		});
    }
}
