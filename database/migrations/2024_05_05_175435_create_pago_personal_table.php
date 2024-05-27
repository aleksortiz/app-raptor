<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagoPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_personal', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('personal_id')->constrained('personal');
            $table->foreignId('entrada_id')->nullable()->constrained('entradas');
            $table->integer('porcentaje');
            $table->decimal('pago', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pago_personal');
    }
}
