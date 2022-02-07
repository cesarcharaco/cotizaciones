<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosBorealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_boreal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cotizacion');
            $table->string('guia_boreal');
            $table->date('fecha_gb');
            $table->string('nombre_pdf_gb');
            $table->string('url_pdf_gb');
            $table->string('oc_boreal');
            $table->date('fecha_ocb');
            $table->string('nombre_pdf_ocb');
            $table->string('url_pdf_ocb');
            
            $table->foreign('id_cotizacion')->references('id')->on('cotizaciones');
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
        Schema::dropIfExists('datos_boreal');
    }
}
