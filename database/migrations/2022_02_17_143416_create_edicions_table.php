<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEdicionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edicions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->string('solicitante');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('idcertificado');
            $table->foreign('idcertificado')->references('id')->on('certificados');
            $table->string('revisor')->nullable();;
            $table->string('nombre_empresa')->nullable();;
            $table->string('designacion')->nullable();;
            $table->string('horas')->nullable();;
            $table->date('fecha_solicitud');
            $table->date('fecha_aprobacion')->nullable();;
            $table->string('firma')->nullable();;
            $table->string('foto')->nullable();;
            $table->string('carne')->nullable();;
            $table->string('anulacion')->nullable();;
            $table->string('cliente')->nullable();;
            $table->text('comentario')->nullable();;
            $table->tinyInteger('condicion');
            $table->string('otros');
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
        Schema::dropIfExists('edicions');
    }
}
