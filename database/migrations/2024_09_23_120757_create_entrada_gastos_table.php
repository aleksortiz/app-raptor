<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntradaGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_gastos', function (Blueprint $table) {
          $table->id();
          $table->foreignId('user_id')->constrained('users');
          $table->foreignId('entrada_id')->constrained('entradas');
          $table->string('concepto');
          $table->decimal('monto', 10, 2);
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
        Schema::dropIfExists('entrada_gastos');
    }
}
