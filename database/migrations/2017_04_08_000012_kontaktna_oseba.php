<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KontaktnaOseba extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Kontaktna_oseba', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_kontaktna_oseba');
            $table->string('priimek', 64);
			$table->string('ime', 64);
			$table->char('telefon', 15);
			$table->string('naslov', 100);
			$table->unsignedInteger('posta');
			$table->unsignedInteger('sorodstveno_razmerje');

			// Foreign key constraints.
			$table->foreign('posta')->references('postna_stevilka')->on('Posta');
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
        Schema::dropIfExists('Kontaktna_oseba');
    }
}
