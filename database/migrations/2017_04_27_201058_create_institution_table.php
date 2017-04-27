<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitutionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Institution', function (Blueprint $table) {
			$table->increments('institution_id');
			$table->string('institution_title', 100);
			$table->string('institution_address', 100);
			$table->unsignedInteger('post_number');

			$table->foreign('post_number')->references('post_number')
					->on('Post');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Institution');
	}
}
