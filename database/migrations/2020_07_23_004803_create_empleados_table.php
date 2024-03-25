<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noEmpleado',10);
            $table->string('nss',80);
            $table->integer('fk_user')->unsigned();
            $table->integer('fk_puesto')->unsigned();
            $table->boolean('estatus')->default(1);
            $table->timestamps();

            $table->foreign('fk_user')->references('id')->on('users');
            $table->foreign('fk_puesto')->references('id')->on('puestos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
