<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idautorizacion_lote');
            $table->foreign('idautorizacion_lote')->references('id')->on('autorizacion_lotes');
            $table->string('numero');
            $table->string('nombre');
            $table->string('solicitante');
            $table->string('aprobador');
            $table->date('fecha_autorizacion');
            $table->Integer('start_code')->default('1');
            $table->Integer('end_code');
            $table->Integer('cantidad');
            $table->Integer('stock');
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
        Schema::dropIfExists('lotes');
    }
}
