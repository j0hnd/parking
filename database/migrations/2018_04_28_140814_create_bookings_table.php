<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->string('email', 100)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['first_name', 'last_name']);
            $table->index('email');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('booking_id', 30)->unique();
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->integer('price_id');
            $table->string('order_title', 50);
            $table->float('price_value');
            $table->float('revenue_value');
            $table->datetime('drop_off_at');
            $table->datetime('return_at');
            $table->string('flight_no_going')->nullable();
            $table->string('flight_no_return')->nullable();
            $table->string('car_registration_no', 100)->nullable();
            $table->string('vehicle_make', 100)->nullable();
            $table->integer('car_model')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['booking_id', 'customer_id', 'product_id', 'price_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
        Schema::dropIfExists('bookings');
    }
}
