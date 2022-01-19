<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrelativosCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correlativos_cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_cotizacion');
            $table->enum('status',['Disponible','No Disponible'])->default('Disponible');
            $table->date('fecha');
            $table->integer('id_usuario')->nullable();
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
        Schema::dropIfExists('correlativos_cotizaciones');
    }
}
