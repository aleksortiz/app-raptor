<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_ventas', function (Blueprint $table) {
            $table->id();
            $table->string('vendedor');
            $table->foreignId('vehiculo_id')->constrained()->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('comprador');
            $table->string('comprador_domicilio');
            $table->date('fecha');
            $table->string('lugar');
            $table->decimal('precio_venta', 10, 2);
            $table->integer('plazos');
            $table->decimal('anticipo', 10, 2);
            $table->string('identificacion')->nullable();
            $table->string('no_identificacion')->nullable();
            $table->integer('kilometraje')->nullable();
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
        Schema::dropIfExists('vehiculo_ventas');
    }
}
