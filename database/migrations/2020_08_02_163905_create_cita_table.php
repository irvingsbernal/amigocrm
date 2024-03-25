<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita', function (Blueprint $table) {
            $table->increments('id');
            $table->string('comentario')->nullable();
            $table->date('fecha');
            // $table->time('hora');
            $table->integer('estatus')->default(0);

            $table->integer('fk_horario')->unsigned();
            $table->integer('fk_auto')->unsigned();
            $table->integer('fk_usuario')->unsigned();
            $table->integer('fk_sucursal')->unsigned();

            $table->foreign('fk_horario')->references('id')->on('horarios');
            $table->foreign('fk_auto')->references('id')->on('autos');
            $table->foreign('fk_usuario')->references('id')->on('users');
            $table->foreign('fk_sucursal')->references('id')->on('sucursales');
            
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
        Schema::dropIfExists('cita');
    }
}
