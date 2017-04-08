<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VzdrzevaniPacient extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Vzdrzevani_pacient', function(Blueprint $table) {
			// Collumn definitions.
            $table->unsignedInteger('vzdrzevani_pacient');
            $table->unsignedInteger('skrbnik');
			$table->unsignedInteger('sorodstveno_razmerje');

			// Foreign key constraints.
			$table->foreign('vzdrzevani_pacient')->references('id_pacient')
				->on('Pacient');
			$table->foreign('skrbnik')->references('id_pacient')->on('Pacient');
			$table->foreign('sorodstveno_razmerje')
				->references('id_sorodstveno_razmerje')
				->on('Sorodstveno_razmerje');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Vzdrzevani_pacient');
    }
}
