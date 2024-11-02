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
            $table->foreignId('user_id')->constrained();
            $table->string('cliente');
            $table->string('telefono');
            $table->string('marca');
            $table->string('modelo');
            $table->string('year')->nullable();
            $table->integer('kilometros')->nullable();
            $table->string('color');
            $table->string('placas')->nullable();
            $table->string('notas')->nullable();
            $table->integer('gasolina');
            $table->json('inventario');
            $table->json('testigos');
            $table->json('carroceria');
            $table->json('mecanica');
            $table->json('servicios_extras');
            $table->text('firma')->nullable();
            $table->mediumText('diagrama')->nullable();
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
