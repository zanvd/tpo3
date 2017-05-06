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
			$table->boolean('substitution')->default(false);
			$table->unsignedInteger('visit_subtype_id');
			$table->integer('performer_id');
			$table->integer('prescriber_id');

			$table->foreign('visit_subtype_id')->references('visit_subtype_id')->on('VisitSubtype');
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
