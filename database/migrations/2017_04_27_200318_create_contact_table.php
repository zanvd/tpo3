<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Contact', function (Blueprint $table) {
			$table->increments('contact_id');
			$table->string('contact_name', 60);
			$table->string('contact_surname', 60);
			$table->string('contact_phone_num', 15);
			$table->string('contact_address', 100);
			$table->unsignedInteger('post_number');
			$table->unsignedInteger('relationship_id');

			$table->foreign('post_number')->references('post_number')
					->on('Post');
			$table->foreign('relationship_id')
				  ->references('relationship_id')->on('Relationship');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('Contact');
	}
}
