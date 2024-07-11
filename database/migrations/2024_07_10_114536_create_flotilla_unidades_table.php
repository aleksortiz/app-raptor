<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlotillaUnidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flotilla_unidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flotilla_id')->constrained('flotillas');
            $table->string('fabricante');
            $table->string('modelo');
            $table->integer('year');
            $table->string('serie')->nullable();
            $table->string('placas')->nullable();
            $table->string('estado');
            $table->integer('kilometraje');
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
        Schema::dropIfExists('flotilla_unidades');
    }
}
