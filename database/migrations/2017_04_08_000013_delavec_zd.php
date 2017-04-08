<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelavecZd extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Delavec_ZD', function(Blueprint $table) {
			// Collumn definitions.
			$table->unsignedInteger('id_delavec')->primary();
			$table->string('priimek', 64);
			$table->string('ime', 64);
			$table->char('telefon', 15);
			$table->string('funkcija', 30);
			$table->unsignedInteger('uporabnik')->unique();
			$table->unsignedInteger('izvajalec');
			$table->unsignedInteger('okolis');

			// Foreign key constraints.
			$table->foreign('uporabnik')->references('id_uporabnik')
				->on('Uporabnik');
			$table->foreign('izvajalec')->references('id_izvajalec')
				->on('Izvajalec_zdravstevnih_storitev');
			$table->foreign('okolis')->references('id_okolis')->on('Okolis');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Delavec_ZD');
    }
}
