<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('cliente');
            $table->string('marca');
            $table->string('modelo');
            $table->string('year');
            $table->integer('kilometros');
            $table->string('telefono');
            $table->string('color');
            $table->string('placas');
            $table->string('notes');
            $table->integer('gasolina');
            $table->json('data');
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
        Schema::dropIfExists('entrada_inventarios');
    }
}
