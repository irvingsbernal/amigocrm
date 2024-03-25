<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fk_proveedor')->unsigned();
            $table->foreign('fk_proveedor')->references('id')->on('proveedores');

            $table->integer('fk_user')->unsigned();
            $table->foreign('fk_user')->references('id')->on('users');

            $table->string('documento');
            $table->string('serieDocumento')->nullable();
            $table->string('noDocumento');
            $table->dateTime('fechaHora');
            $table->decimal('impuesto', 4, 2);
            $table->decimal('total', 11, 2);
            $table->string('estatus', 30);
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
        Schema::dropIfExists('ingresos');
    }
}
