<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroFacturaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_facturas', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('numero_factura');
            $table->decimal('monto', 10, 2);
            $table->string('notas')->nullable();
            $table->dateTime('fecha_pago')->nullable();
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
        Schema::dropIfExists('registro_facturas');
    }
}
