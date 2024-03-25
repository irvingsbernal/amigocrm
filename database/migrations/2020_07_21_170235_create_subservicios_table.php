<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubserviciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subservicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_servicio')->unsigned();
            $table->string('nombre', 100);
            $table->decimal('costoServicio',11,2);
            $table->boolean('estatus')->default(1);
            $table->timestamps();

            $table->foreign('fk_servicio')->references('id')->on('servicios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subservicios');
    }
}
