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
        Schema::create('airports', function (Blueprint $table) {
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
            $table->string('image', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['airport_name', 'country_id']);
        });

        Schema::create('carparks', function (Blueprint $table) {
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

        Schema::create('subcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airport_id');
            $table->integer('subcategory_id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carpark_id');
            $table->text('description')->nullable();
            $table->text('on_arrival');
            $table->text('on_return');
            $table->float('revenue_share')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index('carpark_id');
        });

        Schema::create('product_airports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('airport_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'airport_id']);
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->string('price_start_day', 20)->nullable();
            $table->string('price_end_day', 20)->nullable();
            $table->string('price_month', 20)->nullable();
            $table->string('price_year', 20)->nullable();
            $table->float('price_value')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'category_id']);
        });

        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('service_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'service_id']);
        });

        Schema::create('carpark_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_name', 30);
            $table->softDeletes();
            $table->timestamps();

            $table->index('service_name');
        });

        Schema::create('price_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 20);
            $table->softDeletes();
            $table->timestamps();

            $table->index('category_name');
        });

        Schema::create('countries', function (Blueprint $table) {
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
        Schema::dropIfExists('airports');
        Schema::dropIfExists('carparks');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('services');
        Schema::dropIfExists('carpark_services');
        Schema::dropIfExists('price_categories');
        Schema::dropIfExists('countries');
    }
}
