<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CotizadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cotizadores')->insert([
        	['cotizador' => 'Fernando Olivares','telefono' => '99999999999', 'correo' => 'fernando@comercialboreal.cl','id_usuario' => 2],
        	['cotizador' => 'Daniel Olivares','telefono' => '88888888888', 'correo' => 'daniel@comercialboreal.com','id_usuario' => 3],
        	['cotizador' => 'Guillermo Olivares','telefono' => '77777777777', 'correo' => 'guillermo@comercialboreal.com','id_usuario' => 4],
        	['cotizador' => 'Rodrigo Tapia','telefono' => '66666666666', 'correo' => 'rodrigo@comercialboreal.com','id_usuario' => 5],
        	['cotizador' => 'Felipe Tapia','telefono' => '55555555555', 'correo' => 'felipe@comercialboreal.com','id_usuario' => 6]/*,
        	['cotizador' => 'Janneth Jackson','telefono' => '44444444444', 'correo' => 'janneth@comercialboreal.com','id_usuario' => 7],
        	['cotizador' => 'Alejandro Fernandez','telefono' => '33333333333', 'correo' => 'alejandro@comercialboreal.com','id_usuario' => 8],
        	['cotizador' => 'Thalia Motola','telefono' => '22222222222', 'correo' => 'thalia@comercialboreal.com','id_usuario' => 9],
        	['cotizador' => 'Bruno Mars','telefono' => '11111111111', 'correo' => 'bruno@comercialboreal.com','id_usuario' => 10],
        	['cotizador' => 'Adele','telefono' => '12345678987', 'correo' => 'adele@comercialboreal.com','id_usuario' => 11],
        	['cotizador' => 'James Blunt','telefono' => '98765432123', 'correo' => 'james@comercialboreal.com','id_usuario' => 12],
        	['cotizador' => 'Nelly Furtado','telefono' => '98765456789', 'correo' => 'nelly@comercialboreal.com','id_usuario' => 13],*/
        ]);
    }
}
