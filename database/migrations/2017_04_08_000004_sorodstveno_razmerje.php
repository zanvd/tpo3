<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SorodstvenoRazmerje extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Sorodstveno_razmerje', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_sorodstveno_razmerje');
			$table->string('naziv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Sorodstveno_razmerje');
    }
}
