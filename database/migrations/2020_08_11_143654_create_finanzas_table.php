<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanzasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finanzas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('registro',15);
            $table->string('tipo',80);
            $table->string('concepto');
            $table->date('fecha');
            $table->decimal('monto', 11, 2);
            $table->string('documento');
            $table->string('serieDocumento')->nullable();
            $table->string('noDocumento');
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
        Schema::dropIfExists('finanzas');
    }
}
