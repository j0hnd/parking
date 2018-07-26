<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProductContactDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_contact_details', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('carpark_id');
			$table->integer('product_id');
            $table->string('contact_person_name');
            $table->string('contact_person_email');
            $table->string('contact_person_phone_no');
            $table->tinyInteger('is_active')->default(0);
			$table->softDeletes();
			$table->timestamps();

			$table->index(['carpark_id', 'product_id', 'is_active']);
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
        Schema::dropIfExists('product_contact_details');
    }
}
