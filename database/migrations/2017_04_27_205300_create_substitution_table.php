<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubstitutionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Substitution', function (Blueprint $table) {
			$table->increments('substitution_id');
			$table->date('start_date');
			$table->date('end_date');
			$table->integer('employee_absent');
			$table->integer('employee_substitution');

			$table->foreign('employee_absent')
				  ->references('employee_id')->on('Employee');
			$table->foreign('employee_substitution')
				  ->references('employee_id')->on('Employee');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Substitution');
	}
}
