<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('User', function (Blueprint $table) {
			$table->increments('user_id');
			$table->string('email', 128);
			$table->string('password', 255);
			$table->dateTime('created_at');
			$table->dateTime('last_login');
			$table->boolean('active');
			$table->unsignedInteger('user_role_id');
			$table->unsignedInteger('person_id');

			$table->foreign('user_role_id')->references('user_role_id')
					->on('UserRole');
			$table->foreign('person_id')->references('person_id')
					->on('Person');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('User');
	}
}
