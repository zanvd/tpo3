<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResetLinkTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('ResetLink', function (Blueprint $table) {
			$table->increments('reset_link_id');
			$table->char('reset_link_token', 45);
			$table->dateTime('reset_link_expiry');
			$table->unsignedInteger('user_id');

			$table->foreign('user_id')->references('user_id')->on('User');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('ResetLink');
	}
}
