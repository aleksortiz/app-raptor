<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidoConceptoTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedido_concepto_temps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_temp_id')->constrained('pedido_temps');
            $table->foreignId('material_id')->nullable()->constrained('materiales');
            $table->string('codigo');
            $table->string('descripcion');
            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio', 10, 2);
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
        Schema::dropIfExists('pedido_concepto_temps');
    }
}
