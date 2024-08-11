<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarnesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carnes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('iddesignacion');
            $table->foreign('iddesignacion')->references('id')->on('designacions');
            $table->unsignedBigInteger('idcertificado');
            $table->foreign('idcertificado')->references('id')->on('certificados');
            $table->string('foto')->nullable();
            $table->string('designacion_espanol');
            $table->string('equipo_espanol')->nullable();
            $table->string('normativa_espanol');
            $table->boolean('reevaluacion')->default('1');
            $table->date('fecha_reevaluacion')->nullable();
            $table->boolean('estado')->default('1');
            $table->text('nombrescarne')->nullable();
            $table->text('empresacarne')->nullable();
            $table->text('designacioncarne')->nullable();
            $table->text('fechacarne')->nullable();
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
        Schema::dropIfExists('carnes');
    }
}
