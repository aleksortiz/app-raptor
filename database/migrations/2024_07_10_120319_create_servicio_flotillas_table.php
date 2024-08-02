<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioFlotillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_flotillas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flotilla_unidad_id')->constrained('flotilla_unidades');
            $table->string('tipo_servicio'); //MECANICO, ELECTRICO, TRANSIMISION, SUSPENSION, FRENOS, AFINACION, OTROS
            $table->text('descripcion');
            $table->dateTime('fecha_servicio');
            $table->decimal('costo', 10, 2);
            $table->integer('kilometraje')->nullable();
            $table->string('ubicacion');
            $table->string('estatus_servicio')->default('PENDIENTE');
            $table->dateTime('fecha_concluido')->nullable();
            $table->string('tecnico_asignado')->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('servicio_flotillas');
    }
}
