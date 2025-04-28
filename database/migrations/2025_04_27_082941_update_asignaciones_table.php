<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('asignaciones', function (Blueprint $table) {
            // Eliminar columnas antiguas
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('asignacion');
            $table->dropColumn('fecha_promesa');
            $table->dropColumn('fecha_terminado');

            // Agregar nuevas columnas
            $table->text('descripcion_trabajo')->after('personal_id');
            $table->dateTime('fecha_realizado')->nullable()->after('descripcion_trabajo');
            $table->enum('estado', ['pendiente', 'en_proceso', 'completado'])->default('pendiente')->after('fecha_realizado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignaciones', function (Blueprint $table) {
            // Revertir cambios
            $table->foreignId('user_id')->after('id')->constrained('users');
            $table->string('asignacion')->after('entrada_id');
            $table->dateTime('fecha_promesa')->after('asignacion');
            $table->dateTime('fecha_terminado')->nullable()->after('fecha_promesa');

            // Eliminar nuevas columnas
            $table->dropColumn('descripcion_trabajo');
            $table->dropColumn('fecha_realizado');
            $table->dropColumn('estado');
        });
    }
};
