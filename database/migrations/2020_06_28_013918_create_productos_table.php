<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('FkidCategoria')->unsigned();
            $table->string('nombre',100);
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
                //En qué presentación viene el producto (Hay aceites de: 0.450 lts., 3 kg., 5 lts., etc.):
            $table->string('presentacionInterfaz')->nullable();
            $table->decimal('presentacion', 7,3)->nullable();
                //Clasificamos la unidad de medida de la presentación (lt y kg):
            $table->string('unidad')->nullable()->default('N/A');
            $table->string('codigoBarras')->nullable();
            $table->string('descripcion',250)->nullable();
            $table->decimal('precioCompra',11,2)->default(0);
            $table->decimal('precioVenta',11,2)->nullable();
            $table->longText('imagen')->nullable();
            //$table->integer('stock');
            $table->boolean('ventaXpartes')->default(0);
            $table->boolean('estatus')->default(1);
            $table->timestamps();

            $table->foreign('FkidCategoria')->references('id')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * 
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}