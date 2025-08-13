<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisicionFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicion_facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->nullableMorphs('model');
            $table->string('uso_cfdi');
            $table->string('metodo_pago');
            $table->text('descripcion');
            $table->decimal('monto', 10, 2);
            $table->string('numero_factura')->nullable();
            $table->date('fecha_facturacion')->nullable();
            $table->date('fecha_pago')->nullable();
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
        Schema::dropIfExists('requisicion_facturas');
    }
}
