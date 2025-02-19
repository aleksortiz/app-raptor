<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('marca');
            $table->string('modelo');
            $table->integer('year');
            $table->string('color');
            $table->string('placa')->nullable();
            $table->string('serie')->nullable();
            $table->string('factura')->nullable();
            $table->string('pedimento')->nullable();
            $table->decimal('costo', 8, 2)->default(0);
            $table->decimal('flete', 8, 2)->default(0);
            $table->decimal('importacion', 8, 2)->default(0);
            $table->decimal('precio_venta', 8, 2)->default(0);
            $table->string('estado');
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
        Schema::dropIfExists('vehiculos');
    }
}
