<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderMeasurementTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('WorkOrder_Measurement', function (Blueprint $table) {
			$table->unsignedInteger('measurement_id');
			$table->unsignedInteger('work_order_id');
			$table->unsignedInteger('patient_id');
			$table->unsignedInteger('measurement_value')->nullable();
			$table->date('measurement_date')->nullable();

			$table->foreign('measurement_id')->references('measurement_id')->on('Measurement');
			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
			$table->foreign('patient_id')->references('patient_id')->on('Patient');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('WorkOrder_Measurement');
	}
}
