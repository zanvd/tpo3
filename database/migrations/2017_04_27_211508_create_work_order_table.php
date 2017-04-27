<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkOrderTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('WorkOrder', function (Blueprint $table) {
			$table->increments('work_order_id');
			$table->dateTime('created_at');
			$table->date('start_date');
			$table->date('end_date');
			$table->boolean('substitution');
			$table->unsignedInteger('service_id');
			$table->integer('performer_id');
			$table->integer('prescriber_id');

			$table->foreign('service_id')->references('service_id')->on('Service');
			$table->foreign('performer_id')->references('employee_id')->on('Employee');
			$table->foreign('prescriber_id')->references('employee_id')->on('Employee');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('WorkOrder');
	}
}
