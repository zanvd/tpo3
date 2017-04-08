<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelovniNalogPacient extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Delovni_nalog_Pacient', function(Blueprint $table) {
			// Collumn definitions.
			$table->unsignedInteger('delovni_nalog');
            $table->unsignedInteger('pacient');

			// Primary key definition.
			$table->primary(['delovni_nalog', 'pacient']);

			// Foreign key constraints.
			$table->foreign('delovni_nalog')->references('id_delovni_nalog')
				->on('Delovni_nalog');
			$table->foreign('pacient')->references('id_pacient')->on('Pacient');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Delovni_nalog_Pacient');
    }
}
