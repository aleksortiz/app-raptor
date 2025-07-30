<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCitaReparacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cita_reparacion', function (Blueprint $table) {
            $table->unsignedBigInteger('valuacion_id')->nullable();
            $table->foreign('valuacion_id')->references('id')->on('valuaciones')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cita_reparacion', function (Blueprint $table) {
            $table->dropForeign(['valuacion_id']);
            $table->dropColumn('valuacion_id');
        });
    }
}
