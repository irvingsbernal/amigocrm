<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenSubservicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_subservicio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_orden')->unsigned();
            $table->integer('fk_subservicio')->unsigned();
            $table->decimal('precioServicio',11,2);
            // Estatus para saber si ya se hizo el subservicio 
            $table->boolean('estatus')->default(1);
            $table->timestamps();
            $table->foreign('fk_orden')->references('id')->on('orden_servicio');
            $table->foreign('fk_subservicio')->references('id')->on('subservicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_subservicio');
    }
}
