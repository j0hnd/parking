<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBookingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('booking_details', function($table) {
			$table->increments('id');
			$table->integer('booking_id');
			$table->integer('no_of_passengers_in_vehicle')->default(0);
			$table->tinyInteger('with_oversize_baggage')->default(0);
			$table->tinyInteger('with_children_pwd')->default(0);
			$table->softDeletes();
			$table->timestamps();

			$table->index(['booking_id']);
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
		Schema::dropIfExists('booking_details');
    }
}
