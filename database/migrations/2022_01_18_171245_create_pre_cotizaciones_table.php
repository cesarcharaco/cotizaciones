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
            $table->string('solicitante');
            $table->string('cotizador');
            $table->string('oc_recibida')->nullable();
            $table->float('valor_total')->nullable();
            $table->integer('guia_boreal')->nullable();
            $table->integer('factura_boreal')->nullable();
            $table->string('fecha_entrega')->nullable();
            $table->string('oc_boreal')->nullable();
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
