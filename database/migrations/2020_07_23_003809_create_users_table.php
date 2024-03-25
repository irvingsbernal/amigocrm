<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',80);
            $table->string('apellidoPaterno',80);
            $table->string('apellidoMaterno',80)->nullable()->default('');
            $table->string('rfc',20)->nullable();
            $table->string('direccion',250)->nullable();
            $table->string('telefono')->nullable();
            $table->longText('foto')->nullable();
            $table->string('correo')->unique();
            $table->string('password');
            $table->string('rol', 30);
            $table->boolean('estatus')->default(1);
    
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
