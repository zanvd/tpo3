<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KrovnaMeritev extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Krovna_meritev', function (Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_krovna_meritev');
            $table->string('krovna_meritev_naziv', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Krovna_meritev');
    }
}
