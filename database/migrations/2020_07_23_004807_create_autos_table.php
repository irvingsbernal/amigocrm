<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('marca');
            $table->string('modelo')->nullable();
            $table->integer('anio')->default(2000);
            $table->string('numerovinserie');
            $table->string('color');
            $table->string('placa');
            $table->string('kilometraje')->nullable();
            $table->longText('fotografia')->nullable();
            $table->boolean('estatus')->default(1);
            $table->timestamps();
            $table->integer('fk_cliente')->unsigned();
            $table->foreign('fk_cliente')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autos');
    }
}
