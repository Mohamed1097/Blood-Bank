<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->string('phone', 11);
			$table->date('last_donation_date');
			$table->date('d_o_b');
			$table->integer('blood_type_id')->unsigned();
			$table->integer('city_id')->unsigned();
			$table->string('pin_code');
			$table->string('allowed_blood_types_ids')->nullable();
			$table->string('allowed_cities_ids')->nullable();
			$table->string('api_token', 60);
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}