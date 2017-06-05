<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanMaterialTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('Plan_Material', function (Blueprint $table) {
            $table->unsignedInteger('plan_id');
            $table->unsignedInteger('material_id');
            $table->integer('material_quantity');

            $table->foreign('material_id')->references('material_id')->on('Material');
            $table->foreign('plan_id')->references('plan_id')->on('Plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Plan_Material');
    }
}
