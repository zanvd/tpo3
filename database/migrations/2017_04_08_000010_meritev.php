<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Meritev extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Meritev', function(Blueprint $table) {
            $table->increments('id_meritev');
            $table->string('meritev_naziv');
			$table->string('meritev_enota');
			$table->unsignedInteger('krovna_meritev');

			// Foreign ket constraints.
			$table->foreign('krovna_meritev')->references('id_krovna_meritev')
				->on('Krovna_meritev');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Meritev');
    }
}
