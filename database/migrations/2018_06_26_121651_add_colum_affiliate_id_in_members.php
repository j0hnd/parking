<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumAffiliateIdInMembers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('members', function($table) {
			$table->string('affiliate_id', 255)->after('company_id');
			$table->index('affiliate_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('members', function (Blueprint $table) {
			$table->dropColumn('affiliate_id');
		});
    }
}
