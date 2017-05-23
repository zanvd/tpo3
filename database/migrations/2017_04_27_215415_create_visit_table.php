<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Visit', function (Blueprint $table) {
			$table->increments('visit_id');
			$table->date('planned_date');
			$table->boolean('first_visit');
			$table->boolean('fixed_visit');
			$table->boolean('done')->default(false);
			$table->unsignedInteger('work_order_id');
			$table->unsignedInteger('substitution_id')->nullable();

			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
			$table->foreign('substitution_id')->references('substitution_id')->on('Substitution');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Visit');
	}
}
