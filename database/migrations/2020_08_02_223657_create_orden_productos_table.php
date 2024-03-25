<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fk_orden')->unsigned();
            $table->integer('fk_producto')->unsigned();
            $table->decimal('cantidad',11,2);
            $table->decimal('precioProducto',11,2);
            $table->timestamps();
            $table->foreign('fk_orden')->references('id')->on('orden_servicio');
            $table->foreign('fk_producto')->references('id')->on('productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_productos');
    }
}
