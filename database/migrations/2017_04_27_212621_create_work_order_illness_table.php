<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderIllnessTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('WorkOrder_Illness', function (Blueprint $table) {
			$table->string('illness_id', 7);
			$table->unsignedInteger('work_order_id');

			$table->foreign('illness_id')->references('illness_id')->on('Illness');
			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('WorkOrder_Illness');
	}
}
