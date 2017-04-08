<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelovniNalogMaterial extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Delovni_nalog_Material', function(Blueprint $table) {
			// Collumn definitions.
			$table->unsignedInteger('delovni_nalog');
			$table->unsignedInteger('material');
			$table->integer('material_kolicina');

			// Primary key definition.
			$table->primary(['delovni_nalog', 'material']);

			// Foreign key constraints.
			$table->foreign('delovni_nalog')->references('id_delovni_nalog')
				->on('Delovni_nalog');
			$table->foreign('material')->references('id_material')
				->on('Material');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Delovni_nalog_Material');
    }
}
