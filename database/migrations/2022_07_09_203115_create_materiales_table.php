<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('numero_parte');
            $table->string('categoria');
            $table->string('descripcion');
            $table->string('unidad_medida', 10);
            $table->decimal('precio', 12, 2, true);
            $table->decimal('existencia', 12, 2);
            $table->string('comentarios')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('materiales');
    }
};
