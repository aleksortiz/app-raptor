<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entradas', function (Blueprint $table) {
            $table->text('inventario')->nullable();
            $table->string('placas')->nullable();
            $table->string('color')->nullable();
            $table->string('year')->nullable();
            $table->string('kilometraje')->nullable();
            $table->string('gasolina')->nullable();
            $table->json('testigos')->nullable();
        });
    }
}
