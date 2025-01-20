<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresupuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->morphs('model');
            $table->string('marca');
            $table->string('modelo');
            $table->integer('year');
            $table->string('color');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva', 10, 2);
            $table->decimal('total', 10, 2);
            $table->integer('mecanica')->default(0);
            $table->integer('hojalateria')->default(0);
            $table->integer('pintura')->default(0);
            $table->integer('armado')->default(0);
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
        Schema::dropIfExists('presupuestos');
    }
}
