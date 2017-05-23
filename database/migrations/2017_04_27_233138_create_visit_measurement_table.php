<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitMeasurementTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Visit_Measurement', function (Blueprint $table) {
			$table->unsignedInteger('visit_id');
			$table->unsignedInteger('measurement_id');
			$table->unsignedInteger('patient_id');
			$table->unsignedInteger('measurement_value')->nullable();
			$table->date('measurement_date')->nullable();

			$table->foreign('visit_id')->references('visit_id')->on('Visit');
			$table->foreign('measurement_id')->references('measurement_id')->on('Measurement');
			$table->foreign('patient_id')->references('patient_id')->on('Patient');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Visit_Measurement');
	}
}
