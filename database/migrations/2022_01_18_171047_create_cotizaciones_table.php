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
            $table->integer('guia_boreal')->nullable();
            $table->integer('factura_boreal')->nullable();
            $table->date('fecha_entrega');
            $table->string('oc_boreal')->nullable();
            $table->enum('status',['Pendiente','Contestada','Adjudicada','Negada','Expirada'])->default('Pendiente');
            $table->enum('status2',['ERP/COTI','Lista para Contestar','En Análisis','Órden de Compra','Entrega Parcial','Entrega Completa','Finalizada'])->default('ERP/COTI');
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
        Schema::dropIfExists('cotizaciones');
    }
}
