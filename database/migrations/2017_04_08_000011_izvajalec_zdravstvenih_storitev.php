<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IzvajalecZdravstvenihStoritev extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Izvajalec_zdravstevnih_storitev', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_izvajalec');
            $table->string('naziv', 100);
			$table->string('naslov', 100);
			$table->unsignedInteger('posta');

			// Foreign key constraints.
			$table->foreign('posta')->references('postna_stevilka')->on('Posta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Izvajalec_zdravstevnih_storitev');
    }
}
