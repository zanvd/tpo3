<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelovniNalogEpruveta extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Delovni_nalog_Epruveta', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_dn_epr');
			$table->unsignedInteger('delovni_nalog');
            $table->unsignedInteger('epruveta');
			$table->tinyInteger('epruveta_stevilo');

			// Foreign key constraints.
			$table->foreign('delovni_nalog')->references('id_delovni_nalog')
				->on('Delovni_nalog');
			$table->foreign('epruveta')->references('id_epruveta')
				->on('Epruveta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Delovni_nalog_Epruveta');
    }
}
