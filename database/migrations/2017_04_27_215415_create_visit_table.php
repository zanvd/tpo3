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
			$table->date('visit_date');
			$table->boolean('first_visit');
			$table->boolean('fixed_visit');
			$table->boolean('done');
			$table->unsignedInteger('visit_subtype_id');
			$table->unsignedInteger('work_order_id');

			$table->foreign('visit_subtype_id')->references('visit_subtype_id')->on('VisitSubtype');
			$table->foreign('work_order_id')->references('work_order_id')->on('WorkOrder');
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
