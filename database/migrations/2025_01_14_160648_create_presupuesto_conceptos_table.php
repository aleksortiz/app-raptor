<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestoConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuesto_conceptos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('presupuesto_id')->constrained();
            $table->string('nomenclatura');
            $table->integer('cantidad');
            $table->string('descripcion');
            $table->decimal('mano_obra', 10, 2);
            $table->decimal('refacciones', 10, 2);
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
        Schema::dropIfExists('presupuesto_conceptos');
    }
}
