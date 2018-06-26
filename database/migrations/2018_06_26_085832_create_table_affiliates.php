<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAffiliates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('affiliates', function (Blueprint $table) {
			$table->increments('id');
			$table->string('code', 8)->unique();
			$table->integer('travel_agent_id');
			$table->integer('percent_admin');
			$table->integer('percent_vendor');
			$table->integer('percent_travel_agent');
			$table->softDeletes();
			$table->timestamps();

			$table->index('travel_agent_id');
			$table->engine = 'InnoDB';
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('affiliates');
    }
}
