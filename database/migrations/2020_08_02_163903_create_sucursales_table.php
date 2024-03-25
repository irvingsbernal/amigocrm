<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombreComercial', 50);
            $table->string('razonSocial', 50);
            $table->string('direccion', 100);
            $table->string('codigoUbicacion', 50)->nullable();
            $table->integer('numEmpleados');
            $table->integer('cupoAutos');
            $table->integer('stockCupo');
            $table->double('longitud')->nullable();
            $table->double('latitud')->nullable();
            $table->string('horaInicio')->nullable();
            $table->string('horaFin')->nullable();
            $table->boolean('estatus')->default(1);
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
        Schema::dropIfExists('sucursales');
    }
}

