<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAffiliateBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('affiliate_bookings', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('affiliate_id');
			$table->integer('booking_id');
			$table->timestamps();

			$table->index(['affiliate_id', 'booking_id']);
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
		Schema::dropIfExists('affiliate_bookings');
    }
}
