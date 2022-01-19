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
        	['cotizador' => 'Justin Beaber','telefono' => '99999999999', 'correo' => 'justin@cotizacionesboreal.com','id_usuario' => 2],
        	['cotizador' => 'Shakira Mebarak','telefono' => '88888888888', 'correo' => 'shakira@cotizacionesboreal.com','id_usuario' => 3],
        	['cotizador' => 'Chester Benintong','telefono' => '77777777777', 'correo' => 'chester@cotizacionesboreal.com','id_usuario' => 4],
        	['cotizador' => 'Jon Bon Jovi','telefono' => '66666666666', 'correo' => 'bonjovi@cotizacionesboreal.com','id_usuario' => 5],
        	['cotizador' => 'Michael Jackson','telefono' => '55555555555', 'correo' => 'michael@cotizacionesboreal.com','id_usuario' => 6],
        	['cotizador' => 'Janneth Jackson','telefono' => '44444444444', 'correo' => 'janneth@cotizacionesboreal.com','id_usuario' => 7],
        	['cotizador' => 'Alejandro Fernandez','telefono' => '33333333333', 'correo' => 'alejandro@cotizacionesboreal.com','id_usuario' => 8],
        	['cotizador' => 'Thalia Motola','telefono' => '22222222222', 'correo' => 'thalia@cotizacionesboreal.com','id_usuario' => 9],
        	['cotizador' => 'Bruno Mars','telefono' => '11111111111', 'correo' => 'bruno@cotizacionesboreal.com','id_usuario' => 10],
        	['cotizador' => 'Adele','telefono' => '12345678987', 'correo' => 'adele@cotizacionesboreal.com','id_usuario' => 11],
        	['cotizador' => 'James Blunt','telefono' => '98765432123', 'correo' => 'james@cotizacionesboreal.com','id_usuario' => 12],
        	['cotizador' => 'Nelly Furtado','telefono' => '98765456789', 'correo' => 'nelly@cotizacionesboreal.com','id_usuario' => 13],
        ]);
    }
}
