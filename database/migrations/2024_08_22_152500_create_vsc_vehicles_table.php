<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVscVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vsc_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('serial')->nullable();
            $table->date('purchase_date');
            $table->decimal('purchase_price', 10, 2);
            $table->date('sale_date')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->string('status');
            $table->string('legal_status');
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('vsc_vehicles');
    }
}
