<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_producto');
            $table->string('plazo_entrega');
            $table->integer('cant')->default(1);
            $table->float('precio_unit');
            $table->float('total_pp');
            $table->string('enlace1_web');
            $table->string('enlace2_web')->nullable();
            $table->string('observacion')->nullable();
            $table->float('pp_ci');
            $table->float('pp_si');
            $table->float('pda');
            $table->integer('traslado');
            $table->float('porc_uti');
            $table->float('uti_x_und');
            $table->float('uti_x_total_p');
            $table->float('boreal');
            $table->unsignedBigInteger('id_cotizacion');

            $table->foreign('id_producto')->references('id')->on('productos');
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
        Schema::dropIfExists('items');
    }
}
