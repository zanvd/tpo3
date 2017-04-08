<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Zdravilo extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Zdravilo', function(Blueprint $table) {
			// Collumn definitions.
			$table->increments('id_zdravilo');
            $table->string('zdravilo_ime', 100);
			$table->string('pakiranje', 30);
			$table->string('oblika', 30);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('Zdravilo');
    }
}
