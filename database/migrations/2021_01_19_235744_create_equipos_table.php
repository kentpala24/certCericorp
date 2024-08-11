<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->string('codigo_certificado');
            $table->string('codigo_informe');
            $table->date('fechaIspeccion');
            $table->date('fechaRecomendada');
            $table->date('fechaEmision');
            $table->string('tipoEquipo');
            $table->string('marca');
            $table->string('modeloEquipo');
            $table->string('serie');
            $table->string('capacidad');
            $table->string('ruc');
            $table->string('cliente');
            $table->string('pdsi');
            $table->string('qr');
            $table->string('otro')->nullable();
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
        Schema::dropIfExists('equipos1');
    }
}
