<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Employee', function (Blueprint $table) {
			$table->unsignedInteger('employee_id')->primary();
			$table->unsignedInteger('person_id');
			$table->unsignedInteger('institution_id');

			$table->foreign('person_id')->references('person_id')
					->on('Person');
			$table->foreign('institution_id')
				  ->references('institution_id')->on('Institution');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Employee');
	}
}
