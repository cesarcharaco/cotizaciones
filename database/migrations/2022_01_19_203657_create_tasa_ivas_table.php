<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasaIvasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasa_ivas', function (Blueprint $table) {
            $table->id();
            $table->float('tasa_i');
            $table->date('fecha_i');
            $table->enum('status_i',['Activa','Inactiva'])->default('Activa');
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
        Schema::dropIfExists('tasa_ivas');
    }
}
