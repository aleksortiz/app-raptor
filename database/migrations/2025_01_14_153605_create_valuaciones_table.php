<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValuacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valuaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cliente_id')->constrained();
            $table->string('numero_reporte');
            $table->string('marca');
            $table->string('modelo');
            $table->integer('year');
            $table->string('color');
            $table->boolean('grua');
            $table->dateTime('fecha_cita')->nullable();
            $table->boolean('valuacion_efectuada')->default(false);
            $table->string('notas')->nullable();
            $table->foreignId('entrada_id')->nullable()->constrained()->nullOnDelete();
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
        Schema::dropIfExists('valuaciones');
    }
}
