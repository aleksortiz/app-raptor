<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropColumn('costo');
            $table->dropColumn('flete');
            $table->dropColumn('importacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->decimal('costo', 8, 2)->default(0);
            $table->decimal('flete', 8, 2)->default(0);
            $table->decimal('importacion', 8, 2)->default(0);
        });
    }
}
