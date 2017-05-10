<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderBloodTubeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('WorkOrder_BloodTubes', function (Blueprint $table) {
			$table->unsignedInteger('blood_tube_id');
			$table->unsignedInteger('work_order_id');
			$table->unsignedInteger('num_of_tubes');

			$table->foreign('blood_tube_id')->references('blood_tube_id')->on('BloodTube');
			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('WorkOrder_BloodTube');
	}
}
