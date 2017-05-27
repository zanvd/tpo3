<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInputTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Input', function (Blueprint $table) {
			$table->increments('input_id');
			$table->string('input_name', 100);
			$table->unsignedInteger('measurement_id');

			$table->foreign('measurement_id')->references('measurement_id')->on('Measurement');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Input');
	}
}
