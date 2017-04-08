<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Obisk extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Obisk', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_obisk');
            $table->string('obisk_vrsta', 30);
			$table->date('obisk_datum');
			$table->boolean('prvi_obisk');
			$table->boolean('fiksen_datum');
			$table->boolean('opravljen');
			$table->boolean('obisk_nadomescanje');
			$table->unsignedInteger('delovni_nalog');

			// Foregin key constraints.
			$table->foreign('delovni_nalog')->references('id_delovni_nalog')
				->on('Delovni_nalog');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Obisk');
    }
}
