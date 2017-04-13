<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pacient extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Pacient', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_pacient');
            $table->integer('zavarovanje_stevilka');
			$table->string('priimek', 64);
			$table->string('ime', 64);
			$table->string('naslov', 100);
			$table->char('telefon', 15);
			$table->date('datum_rojstva');
			$table->char('spol', 1);
			$table->unsignedInteger('uporabnik');
			$table->unsignedInteger('kontaktna_oseba')->nullable();
			$table->unsignedInteger('posta');
			$table->unsignedInteger('okolis');

			// Foreign key constraints.
			$table->foreign('uporabnik')->references('id_uporabnik')
				->on('Uporabnik');
			$table->foreign('kontaktna_oseba')->references('id_kontaktna_oseba')
				->on('Kontaktna_oseba');
			$table->foreign('posta')->references('postna_stevilka')->on('Posta');
			$table->foreign('okolis')->references('id_okolis')->on('Okolis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Pacient');
    }
}
