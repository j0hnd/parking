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
            $table->string('airport_code', 4)->unique();
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
            $table->engine = 'InnoDB';
        });

        Schema::create('carparks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
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

            $table->index(['name', 'company_id', 'country_id']);
            $table->engine = 'InnoDB';
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('airport_id');
            $table->string('subcategory_name', 100);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['airport_id', 'subcategory_name']);
            $table->engine = 'InnoDB';
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('carpark_id');
            $table->text('description')->nullable();
            $table->text('on_arrival');
            $table->text('on_return');
            $table->float('revenue_share')->default(0);
            $table->string('override_dates', 30)->nullabel();
            $table->integer('override_price')->nullabel();
            $table->softDeletes();
            $table->timestamps();

            $table->index('carpark_id');
            $table->engine = 'InnoDB';
        });

        Schema::create('product_airports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('airport_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'airport_id']);
            $table->engine = 'InnoDB';
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('category_id');
            $table->integer('no_of_days')->nullable();
            $table->string('price_month', 20)->nullable();
            $table->string('price_year', 20)->nullable();
            $table->float('price_value')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'category_id']);
            $table->engine = 'InnoDB';
        });

        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('service_id');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['product_id', 'service_id']);
            $table->engine = 'InnoDB';
        });

        Schema::create('carpark_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('service_name', 30);
            $table->string('icon', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('service_name');
            $table->engine = 'InnoDB';
        });

        Schema::create('price_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_name', 20);
            $table->softDeletes();
            $table->timestamps();

            $table->index('category_name');
            $table->engine = 'InnoDB';
        });

        Schema::create('countries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('prefix', 5);
            $table->string('country', 50);
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('first_name', 25);
            $table->string('last_name', 25);
            $table->tinyInteger('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name', 100);
            $table->string('phone_no', 20)->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('email', 100);
            $table->string('vat_no', 20)->nullable();
            $table->string('poc_name', 100)->nullable();
            $table->string('poc_contact_no', 20)->nullable();
            $table->string('poc_contact_email', 100)->nullable();
            $table->string('company_reg', 100)->nullable();
            $table->string('insurance_policy', 200)->nullable();
            $table->string('park_mark', 200)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->index(['company_name']);
        });

        Schema::create('company_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->integer('parent_id')->default(0)->nullable();
            $table->string('meta_key', 50);
            $table->string('meta_value', 255);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['company_id', 'meta_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('services');
        Schema::dropIfExists('carpark_services');
        Schema::dropIfExists('price_categories');
        Schema::dropIfExists('product_airports');
        Schema::dropIfExists('countries');
        Schema::dropIfExists('members');
        Schema::dropIfExists('airports');
        Schema::dropIfExists('carparks');
        Schema::dropIfExists('products');
        Schema::dropIfExists('companies');
        Schema::dropIfExists('company_details');
    }
}
