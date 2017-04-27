<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerificationTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('Verification', function (Blueprint $table) {
			$table->increments('verification_id');
			$table->char('verification_token', 45);
			$table->dateTime('verification_expiry');
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
		Schema::dropIfExists('Verification');
	}
}
