<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAprobacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprobacion_lotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('idsolicitud');
            $table->foreign('idsolicitud')->references('id')->on('solicitud_lotes');
            $table->string('aprobador'); 
            $table->integer('cantidad');
            $table->text('comentario')->nullable(); 
            $table->tinyInteger('condicion'); 
            $table->timestamps();
        });
        DB::update("ALTER TABLE aprobacion_lotes AUTO_INCREMENT = 100;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aprobacion_lotes');
    }
}
