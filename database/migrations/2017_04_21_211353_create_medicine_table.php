<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicineTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Medicine', function (Blueprint $table) {
			$table->increments('medicine_id');
			$table->string('medicine_name', 100);
			$table->string('medicine_packaging', 45);
			$table->string('medicine_type', 45);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Medicine');
	}
}
