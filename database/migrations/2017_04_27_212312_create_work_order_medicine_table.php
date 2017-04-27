<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderMedicineTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('WorkOrder_Medicine', function (Blueprint $table) {
			$table->unsignedInteger('medicine_id');
			$table->unsignedInteger('work_order_id');

			$table->foreign('medicine_id')->references('medicine_id')->on('Medicine');
			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('WorkOrder_Medicine');
	}
}
