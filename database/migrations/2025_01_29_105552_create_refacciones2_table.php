<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefacciones2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('refacciones2', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reporte');
            $table->string('numero_parte')->nullable();
            $table->string('descripcion')->nullable();
            $table->foreignId('proveedor_id')->nullable()->constrained('proveedores');
            $table->date('fecha_promesa')->nullable();
            $table->dateTime('fecha_recepcion')->nullable();
            $table->string('estado');
            $table->string('condicion');
            $table->string('ubicacion')->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->string('notas')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refacciones2');
    }
}
