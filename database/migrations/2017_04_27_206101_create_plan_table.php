<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Plan', function (Blueprint $table) {
			$table->increments('plan_id');
			$table->date('plan_date');
			$table->unsignedInteger('nurse_id');

			$table->foreign('nurse_id')->references('employee_id')->on('Employee');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Plan');
	}
}
