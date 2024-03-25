<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleIngresos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('fk_ingreso')->unsigned();
            $table->foreign('fk_ingreso')->references('id')->on('ingresos')->onDelete('cascade');

            $table->integer('fk_producto')->unsigned();
            $table->foreign('fk_producto')->references('id')->on('productos');
            // $table->string('unidad')->nullable()->default('N/A');
            // $table->decimal('presentacion', 7, 3)->nullable();
            $table->integer('cantidad');
            $table->decimal('precio', 11, 2);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleIngresos');
    }
}
