<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogoPostulantesDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postulantes_detalle', function (Blueprint $table) {
            $table->id();
            $table->string('curp');
            $table->unsignedBigInteger('vacantes_id');
            $table->string('nombre');
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('correo');
            $table->string('telefono1');
            $table->string('telefono2')->nullable();
            $table->string('archivo_cv')->nullable();
            $table->boolean('preseleccionado')->default(false);
            $table->json('requerimientos')->nullable(); // Guardar requerimientos en formato JSON
            $table->float('porcentaje_total')->default(0); // Total de cumplimiento
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
        Schema::dropIfExists('catalogo_postulantes_detalle');
    }
}
