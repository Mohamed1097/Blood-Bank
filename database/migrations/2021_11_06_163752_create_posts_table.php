<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title')->nullable();
			$table->text('content')->nullable();
			$table->string('image');
			$table->integer('post_category_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('posts');
	}
}