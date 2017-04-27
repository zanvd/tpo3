<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Patient', function (Blueprint $table) {
			$table->increments('patient_id');
			$table->char('insurance_num', 11);
			$table->date('birth_date');
			$table->char('sex', 1);
			$table->unsignedInteger('person_id');
			$table->unsignedInteger('contact_id')->nullable();

			$table->foreign('person_id')->references('person_id')->on('Person');
			$table->foreign('contact_id')->references('contact_id')->on('Contact');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Patient');
	}
}
