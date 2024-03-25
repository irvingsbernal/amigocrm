<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_servicio', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('fk_cliente')->unsigned();
            $table->integer('fk_empleado')->unsigned();
            $table->integer('fk_sucursal')->unsigned();
            $table->integer('fk_auto')->unsigned();
            $table->string('fk_cita')->unique()->nullable();
            //$table->integer('fk_cita')->unique()->nullable();
            
            $table->decimal('total',11,2);
            $table->decimal('estadoSaldo',11,2)->nullable();;
            $table->string('estado')->nullable();
            $table->boolean('estatus')->default(1);
            
            $table->foreign('fk_cliente')->references('id')->on('clientes');
            $table->foreign('fk_empleado')->references('id')->on('empleados');
            $table->foreign('fk_sucursal')->references('id')->on('sucursales');
            $table->foreign('fk_auto')->references('id')->on('autos');  
            $table->timestamps();          
            //$table->foreign('fk_cita')->references('id')->on('cita');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orden_servicio');
    }
}
