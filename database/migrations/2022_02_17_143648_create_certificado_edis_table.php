<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificadoEdisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificado_edis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('idpersona');
            $table->foreign('idpersona')->references('id')->on('personas');
            $table->unsignedBigInteger('idtipo_certificado');
            $table->foreign('idtipo_certificado')->references('id')->on('tipo_certificados');
            $table->unsignedBigInteger('idcertificado');
            $table->foreign('idcertificado')->references('id')->on('certificados');
            $table->unsignedBigInteger('idfirma');
            $table->foreign('idfirma')->references('id')->on('firmas');
            $table->unsignedBigInteger('iddesignacion')->default('0');
            $table->foreign('iddesignacion')->references('id')->on('designacions');
            $table->string('pdsi');
            $table->string('persona');
            $table->string('empresa');
            $table->Integer('certificado');
            $table->String('designacion');
            $table->text('equipo')->nullable();
            $table->boolean('cond_equipo');
            $table->string('level');
            $table->string('horas');
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_emision2')->nullable();
            $table->date('fecha_emision3')->nullable();
            $table->date('fecha_emision4')->nullable();
            $table->date('fecha_emision5')->nullable();
            $table->date('fecha_emision6')->nullable();
            $table->date('fecha_emision7');
            $table->date('fecha_revalidacion')->nullable();
            $table->date('fecha_expiracion');
            $table->Integer('dias');
            $table->string('normativa');
            $table->text('description')->nullable();
            $table->text('cabecera')->nullable();
            $table->text('fecha')->nullable();
            $table->string('qr');
            $table->string('ip');
            $table->string('otra_v');
            $table->boolean('condicion');
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
        Schema::dropIfExists('certificado_edis');
    }
}
