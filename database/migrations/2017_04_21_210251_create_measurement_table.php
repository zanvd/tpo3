<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeasurementTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Measurement', function (Blueprint $table) {
			$table->increments('measurement_id');
			$table->text('description');
			$table->boolean('required');
			$table->unsignedInteger('visit_subtype_id');

			$table->foreign('visit_subtype_id')->references('visit_subtype_id')->on('VisitSubtype');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Measurement');
	}
}
