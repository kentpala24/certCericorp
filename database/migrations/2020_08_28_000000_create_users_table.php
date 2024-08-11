<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('idrol');
            $table->foreign('idrol')->references('id')->on('roles');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('tipo_documento');
            $table->string('numero_documento');
            $table->string('telefono');
            $table->string('email');
            $table->string('ip');
            $table->boolean('estado')->default('1');
            $table->string('usuario');
            $table->string('password');
            $table->date('last_login');
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
