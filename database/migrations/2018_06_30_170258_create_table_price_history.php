<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePriceHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('price_histories', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('price_id');
			$table->integer('no_of_days');
			$table->integer('price_month')->nullable();
			$table->integer('price_year')->nullable();
			$table->float('price_value');
			$table->integer('changed_by');
			$table->dateTime('approved_at');
			$table->integer('approved_by');
			$table->timestamps();

			$table->index('price_id');
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
		Schema::dropIfExists('price_histories');
    }
}
