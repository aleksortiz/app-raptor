<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVscExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsc_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vsc_vehicles')->onDelete('cascade');
            $table->string('type');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->text('description');
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
        Schema::dropIfExists('vsc_expenses');
    }
}
