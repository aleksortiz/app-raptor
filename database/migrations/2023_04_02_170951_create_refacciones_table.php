<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefaccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refacciones', function (Blueprint $table) {
            $table->id();
            $table->morphs('model');
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores');
            $table->string('numero_parte');
            $table->string('descripcion');
            $table->string('cantidad');
            $table->decimal('costo', 10, 2);
            $table->decimal('precio', 10, 2);
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
        Schema::dropIfExists('refacciones');
    }
}
