<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DelovniNalogZdravilo extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Delovni_nalog_Zdravilo', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_dn_zdr');
			$table->unsignedInteger('delovni_nalog');
            $table->unsignedInteger('zdravilo');

			// Foreign key constraints.
			$table->foreign('delovni_nalog')->references('id_delovni_nalog')
				->on('Delovni_nalog');
			$table->foreign('zdravilo')->references('id_zdravilo')
				->on('Zdravilo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Delovni_nalog_Zdravilo');
    }
}
