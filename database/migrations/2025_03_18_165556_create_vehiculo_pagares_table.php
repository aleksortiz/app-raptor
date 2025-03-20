<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculoPagaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculo_pagares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained()->onDelete('cascade');
            $table->string('numero_pagare');
            $table->decimal('monto', 10, 2);
            $table->date('fecha');
            $table->date('fecha_pago')->nullable();
            $table->decimal('tasa_interes', 5, 2);
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
        Schema::dropIfExists('vehiculo_pagares');
    }
}
