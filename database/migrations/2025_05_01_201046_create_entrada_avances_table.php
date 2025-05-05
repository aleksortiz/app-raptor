<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaAvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_avances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_id')->constrained()->onDelete('cascade');
            $table->dateTime('carroceria')->nullable();
            $table->dateTime('preparado')->nullable();
            $table->dateTime('pintura')->nullable();
            $table->dateTime('armado')->nullable();
            $table->dateTime('terminado')->nullable();
            $table->dateTime('notificacion_entrega')->nullable();
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
        Schema::dropIfExists('entrada_avances');
    }
}
