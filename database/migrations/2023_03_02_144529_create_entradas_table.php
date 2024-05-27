<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('sucursal_id')->constrained('sucursales');
            $table->foreignId('user_id')->constrained('users');
            $table->string('origen');
            $table->foreignId('aseguradora_id')->constrained('aseguradoras');
            $table->foreignId('fabricante_id')->constrained('fabricantes');
            $table->string('modelo');
            $table->string('notas')->nullable();
            $table->string('serie')->nullable();
            $table->string('orden')->nullable();
            $table->string('numero_factura')->nullable();
            $table->json('area_trabajo');
            $table->string('estatus');
            $table->string('estatus_factura');
            $table->boolean('servicio_interno');
            $table->dateTime('fecha_pago')->nullable();
            $table->dateTime('fecha_concluido')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->dateTime('fecha_pago_refacciones')->nullable();
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
        Schema::dropIfExists('entradas');
    }
}
