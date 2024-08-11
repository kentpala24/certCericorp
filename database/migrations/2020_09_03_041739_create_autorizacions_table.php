<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizacion_lotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idusuario');
            $table->foreign('idusuario')->references('id')->on('users');
            $table->unsignedBigInteger('idaprobacion');
            $table->foreign('idaprobacion')->references('id')->on('aprobacion_lotes');
            $table->string('autorizacion');
            $table->tinyInteger('condicion');
            $table->timestamps();
        });
        DB::update("ALTER TABLE autorizacion_lotes AUTO_INCREMENT = 300;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizacion_lotes');
    }
}
