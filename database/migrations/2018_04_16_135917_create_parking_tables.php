<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aps_airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('airport_name', 100)->unique();
            $table->text('description')->nullable();
            $table->string('address', 50);
            $table->string('address2', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('county_state', 50)->nullable();
            $table->integer('country_id')->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->string('latitude', 20)->nullable();
            $table->integer('subcategory')->default(0);
            $table->string('image', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['airport_name', 'country_id']);
        });

        Schema::create('aps_carparks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->string('address', 50);
            $table->string('address2', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('county_state', 50)->nullable();
            $table->integer('country_id')->nullable();
            $table->string('zipcode', 10)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->string('latitude', 20)->nullable();
            $table->string('image', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['name', 'country_id']);
        });

        Schema::create('aps_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carpark_id');
            $table->integer('airport_id');
            $table->text('description')->nullable();
            $table->string('on_arrival', 255);
            $table->string('on_return', 255);
            $table->float('revenue_share')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['carpark_id', 'airport_id']);
        });

        Schema::create('aps_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->float('price_start_day')->default(0);
            $table->float('price_end_day')->default(0);
            $table->float('price_month')->nullable();
            $table->float('price_year')->nullable();
            $table->float('price_value')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('category_id');
        });

        Schema::create('aps_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('service_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'service_id']);
        });

        Schema::create('aps_carpark_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_name', 30);
            $table->softDeletes();
            $table->timestamps();

            $table->index('service_name');
        });

        Schema::create('aps_price_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 20);
            $table->softDeletes();
            $table->timestamps();

            $table->index('category_name');
        });

        Schema::create('aps_countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix', 5);
            $table->string('country', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aps_airports');
        Schema::dropIfExists('aps_carparks');
        Schema::dropIfExists('aps_products');
        Schema::dropIfExists('aps_prices');
        Schema::dropIfExists('aps_services');
        Schema::dropIfExists('aps_carpark_services');
        Schema::dropIfExists('aps_price_categories');
        Schema::dropIfExists('aps_countries');
    }
}
