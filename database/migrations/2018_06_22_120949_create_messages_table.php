<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('subject');
			$table->text('message')->nullable();
			$table->string('booking_id')->nullable();
            $table->datetime('drop_off')->nullable();
            $table->datetime('return_at')->nullable();
            $table->string('order')->nullable();
            $table->string('name');
            $table->enum('status', ['unread', 'read']);
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
