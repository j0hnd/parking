<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLandingPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
			$table->increments('id');
            $table->integer('airport_id');
            $table->string('name', 30);
            $table->string('slug', 100);
            $table->text('description_1');
            $table->text('description_2');
			$table->softDeletes();
			$table->timestamps();

            $table->index('airport_id');
            $table->index('name');
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
        Schema::dropIfExists('landing_pages');
    }
}
