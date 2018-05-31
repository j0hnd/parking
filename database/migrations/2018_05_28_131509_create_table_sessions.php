<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSessions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('sessions', function($table) {
			$table->string('session_id', 255)->primary();
			$table->string('request_id', 255);
			$table->integer('booking_id')->nullable();
			$table->text('requests')->nullable();
			$table->text('response')->nullable();
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
		Schema::dropIfExists('sessions');
    }
}
