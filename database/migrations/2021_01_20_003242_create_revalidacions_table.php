<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevalidacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revalidacions1', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('iddesignacion');
            $table->foreign('iddesignacion')->references('id')->on('designacions');
            $table->unsignedBigInteger('idpersona');
            $table->foreign('idpersona')->references('id')->on('personas');
            $table->string('numero');
            $table->string('persona');
            $table->string('pdsi');
            $table->string('empresa');
            $table->string('designacion');
            $table->string('equipo');
            $table->boolean('cond_equipo');            
            $table->string('nivel');
            $table->string('foto');
            $table->boolean('revalidacion')->default('1');
            $table->date('fecha_emision')->nullable();
            $table->date('fecha_reevaluacion')->nullable();
            $table->date('fecha_vence')->nullable();
            $table->string('normativa_espanol')->nullable();
            $table->text('nombrescarne')->nullable();
            $table->text('empresacarne')->nullable();
            $table->text('designacioncarne')->nullable();
            $table->boolean('estado')->nullable();
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
        Schema::dropIfExists('revalidacions');
    }
}
