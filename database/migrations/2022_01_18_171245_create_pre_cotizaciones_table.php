<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('fecha');
            $table->integer('numero');
            $table->text('descripcion_general');
            $table->string('empresa');
            $table->unsignedBigInteger('id_solicitante');
            $table->string('cotizador');
            $table->enum('moneda',['Dolar','Euro','Lira','Peso'])->default('Dolar');
            $table->string('oc_recibida')->nullable();
            $table->float('valor_total')->nullable();
            $table->integer('guia_boreal')->nullable();
            $table->integer('factura_boreal')->nullable();
            $table->string('fecha_entrega');
            $table->string('oc_boreal')->nullable();
            $table->enum('status',['En Espera','Procesar'])->default('En Espera');

            $table->foreign('id_solicitante')->references('id')->on('solicitantes');
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
        Schema::dropIfExists('pre_cotizaciones');
    }
}
