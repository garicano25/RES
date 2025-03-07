<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrearTablaDocumentosColaboradorContrato extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    
    {
        Schema::create('DOCUMENTOS_COLABORADOR_CONTRATO', function (Blueprint $table) {
            $table->increments('ID_DOCUMENTO_COLABORADOR_CONTRATO');
            $table->text('CURP')->nullable();
            $table->text('TIPO_DOCUMENTO_SOPORTECONTRATO')->nullable();
            $table->text('NOMBRE_DOCUMENTO_SOPORTECONTRATO')->nullable();
            $table->text('DOCUMENTO_SOPORTECONTRATO')->nullable();
            $table->boolean('ACTIVO')->default(1);
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
        //
    }
}
