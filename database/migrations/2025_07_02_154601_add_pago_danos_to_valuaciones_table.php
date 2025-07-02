<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPagoDanosToValuacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('valuaciones', function (Blueprint $table) {
            $table->boolean('pago_danos')->default(false)->after('entrada_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('valuaciones', function (Blueprint $table) {
            $table->dropColumn('pago_danos');
        });
    }
}
