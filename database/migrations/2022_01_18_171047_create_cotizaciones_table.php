<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('numero_oc');
            $table->text('descripcion_general');
            $table->unsignedBigInteger('id_solicitante');
            $table->unsignedBigInteger('id_cotizador');
            $table->enum('moneda',['Dolar','Euro','Lira','Peso'])->default('Dolar');
            $table->string('oc_recibida')->nullable();
            $table->float('valor_total')->nullable();
            $table->integer('factura_boreal')->nullable();
            $table->date('fecha_entrega');
            $table->enum('status',['Pendiente','Contestada','Adjudicada','Negada','Expirada'])->default('Pendiente');
            $table->enum('status2',['ERP/COTI','Lista para Contestar','En Análisis','En Proceso de Compra','Entrega Parcial','Entrega Completa','Finalizada'])->default('ERP/COTI');
            $table->timestamps();
            //el status Por Cargar Items solo sele dará cuando
            //se tengan factura boreal o OC Recibida para pasar a cargar items y de allí a finalizar 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
}
