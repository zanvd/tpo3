<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderPatientTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('WorkOrder_Patient', function (Blueprint $table) {
			$table->unsignedInteger('patient_id');
			$table->unsignedInteger('work_order_id');

			$table->foreign('patient_id')->references('patient_id')->on('Patient');
			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('WorkOrder_Patient');
	}
}
