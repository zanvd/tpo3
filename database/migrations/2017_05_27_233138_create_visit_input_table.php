<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitInputTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Visit_Input', function (Blueprint $table) {
			$table->unsignedInteger('visit_id');
			$table->unsignedInteger('input_id');
			$table->unsignedInteger('patient_id');
			$table->text('input_value')->nullable();
			$table->date('input_date')->nullable();

			$table->foreign('visit_id')->references('visit_id')->on('Visit');
			$table->foreign('input_id')->references('input_id')->on('Input');
			$table->foreign('patient_id')->references('patient_id')->on('Patient');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Visit_Input');
	}
}
