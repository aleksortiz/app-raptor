<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_id')->nullable()->constrained('entradas');
            $table->foreignId('material_id')->nullable()->constrained('materiales');
            $table->string('numero_parte');
            $table->string('material');
            $table->string('unidad_medida', 10);
            $table->decimal('precio', 12, 2, true);
            $table->decimal('cantidad', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entrada_material');
    }
}
