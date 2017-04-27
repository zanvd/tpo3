<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDependentPatientTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('DependentPatient', function (Blueprint $table) {
			$table->unsignedInteger('dependent_patient_id');
			$table->unsignedInteger('guardian_patient_id');
			$table->unsignedInteger('relationship_id');

			$table->foreign('dependent_patient_id')->references('patient_id')->on('Patient');
			$table->foreign('guardian_patient_id')->references('patient_id')->on('Patient');
			$table->foreign('relationship_id')->references('relationship_id')->on('Relationship');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('DependentPatient');
	}
}
