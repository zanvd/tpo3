<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MeritevObisk extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Meritev_Obisk', function(Blueprint $table) {
			// Collumn definitions.
			$table->unsignedInteger('meritev');
			$table->unsignedInteger('obisk');
			$table->integer('meritev_vrednost');

			// Primary key definition.
			$table->primary(['meritev', 'obisk']);

			// Foreign key constraints.
			$table->foreign('meritev')->references('id_meritev')->on('Meritev');
			$table->foreign('obisk')->references('id_obisk')->on('Obisk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Meritev_Obisk');
    }
}
