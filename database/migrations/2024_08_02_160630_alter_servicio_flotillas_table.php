<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServicioFlotillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicio_flotillas', function (Blueprint $table) {
            $table->string('ubicacion');
            $table->string('estatus_servicio')->default('PENDIENTE');
            $table->dateTime('fecha_concluido')->nullable();
            $table->string('tecnico_asignado')->nullable();
            $table->text('observaciones')->nullable();
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
