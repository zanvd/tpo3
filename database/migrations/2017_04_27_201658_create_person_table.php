<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Person', function (Blueprint $table) {
			$table->increments('person_id');
			$table->string('name', 60);
			$table->string('surname', 60);
			$table->string('phone_num', 15);
			$table->string('address', 100);
			$table->unsignedInteger('post_number');
			$table->unsignedInteger('region_id')->nullable();

			$table->foreign('post_number')->references('post_number')
					->on('Post');
			$table->foreign('region_id')->references('region_id')
					->on('Region');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Person');
	}
}
