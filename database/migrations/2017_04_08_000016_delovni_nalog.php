<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelovniNalog extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Delovni_nalog', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_delovni_nalog');
			$table->dateTime('izdaja_cas');
			$table->unsignedInteger('storitev');
			$table->unsignedInteger('narocnik');
			$table->unsignedInteger('izvajalec');

			// Foreign key constraints.
			$table->foreign('storitev')->references('id_storitev')
				->on('Storitev');
			$table->foreign('narocnik')->references('id_delavec')
				->on('Delavec_ZD');
			$table->foreign('izvajalec')->references('id_delavec')
				->on('Delavec_ZD');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Delovni_nalog');
    }
}
