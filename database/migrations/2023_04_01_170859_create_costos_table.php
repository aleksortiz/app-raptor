<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostosTable extends Migration
{
    
    public function up()
    {
        Schema::create('costos', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->string('concepto');
            $table->decimal('costo', 12, 2);
            $table->dateTime('pagado')->nullable();
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
        Schema::dropIfExists('costos');
    }
}
