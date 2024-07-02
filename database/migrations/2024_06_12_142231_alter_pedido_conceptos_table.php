<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPedidoConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedido_conceptos', function (Blueprint $table) {
            $table->foreignId('entrada_id')->nullable()->constrained('entradas');
        });

        Schema::table('pedido_concepto_temps', function (Blueprint $table) {
            $table->foreignId('entrada_id')->nullable()->constrained('entradas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
