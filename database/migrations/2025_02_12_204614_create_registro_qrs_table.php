<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroQrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_qrs', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reporte');
            $table->string('cliente_nombre');
            $table->string('telefono');
            $table->string('correo')->nullable();
            $table->string('tipo');
            $table->string('marca');
            $table->string('modelo');
            $table->string('year');
            $table->string('color');
            $table->dateTime('fecha_cita');
            $table->string('ine_frontal')->nullable();
            $table->string('ine_reverso')->nullable();
            $table->string('orden_admision')->nullable();
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('registro_qrs');
    }
}
