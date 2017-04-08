<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Nadomescanje extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Nadomescanje', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_nadomescanje');
            $table->date('nadomescanje_zacetek');
			$table->date('nadomescanje_konec');
			$table->unsignedInteger('delavec_odsotni');
			$table->unsignedInteger('delavec_nadomestni');

			// Foreing key constraint.
			$table->foreign('delavec_odsotni')->references('id_delavec')
				->on('Delavec_ZD');
			$table->foreign('delavec_nadomestni')->references('id_delavec')
				->on('Delavec_ZD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Nadomescanje');
    }
}
