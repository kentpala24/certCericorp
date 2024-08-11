<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('idtipo_certificado');
            $table->foreign('idtipo_certificado')->references('id')->on('tipo_certificados');
            $table->string('designacion_ingles');
            $table->string('designacion_espanol');
            $table->string('identifica');
            $table->string('color');
            $table->string('normativa_ingles');
            $table->string('normativa_espanol');
            $table->string('ip');
            $table->boolean('estado')->default('1');
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
        Schema::dropIfExists('designacions');
    }
}
