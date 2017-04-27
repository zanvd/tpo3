<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitSubtypeTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('VisitSubtype', function (Blueprint $table) {
			$table->increments('visit_subtype_id');
			$table->string('visit_subtype_title');
			$table->unsignedInteger('visit_type_id');

			$table->foreign('visit_type_id')
				  ->references('visit_type_id')->on('VisitType');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('VisitSubtype');
	}
}
