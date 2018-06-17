<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('posts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('title', 100);
			$table->string('slug', 255);
			$table->text('content');
			$table->string('image')->nullable();
			$table->enum('status', ['draft', 'published']);
			$table->dateTime('date_published');
			$table->integer('created_by');
			$table->softDeletes();
			$table->timestamps();

			$table->engine = 'InnoDB';

			$table->index('title');
			$table->index('slug');
			$table->index(['created_by', 'status']);
			$table->index('date_published');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('posts');
    }
}
