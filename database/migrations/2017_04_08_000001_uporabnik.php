<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Uporabnik extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Uporabnik', function(Blueprint $table) {
			// Collumn definitions.
            $table->increments('id_uporabnik');
            $table->string('email', 128)->unique();
			$table->char('password', 128);
			$table->string('vloga', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Uporabnik');
    }
}
