<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VendedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('vendedores')->insert([
        	['vendedor' => 'Justin Beaber','telefono' => '99999999999', 'correo' => 'justin@streamingsystem.com'],
        	['vendedor' => 'Shakira Mebarak','telefono' => '88888888888', 'correo' => 'shakira@streamingsystem.com'],
        	['vendedor' => 'Chester Benintong','telefono' => '77777777777', 'correo' => 'chester@streamingsystem.com'],
        	['vendedor' => 'Jon Bon Jovi','telefono' => '66666666666', 'correo' => 'bonjovi@streamingsystem.com'],
        	['vendedor' => 'Michael Jackson','telefono' => '55555555555', 'correo' => 'michael@streamingsystem.com'],
        	['vendedor' => 'Janneth Jackson','telefono' => '44444444444', 'correo' => 'janneth@streamingsystem.com'],
        	['vendedor' => 'Alejandro Fernandez','telefono' => '33333333333', 'correo' => 'alejandro@streamingsystem.com'],
        	['vendedor' => 'Thalia Motola','telefono' => '22222222222', 'correo' => 'thalia@streamingsystem.com'],
        	['vendedor' => 'Bruno Mars','telefono' => '11111111111', 'correo' => 'bruno@streamingsystem.com'],
        	['vendedor' => 'Adele','telefono' => '12345678987', 'correo' => '@streamingsystem.com'],
        	['vendedor' => 'James Blunt','telefono' => '98765432123', 'correo' => 'james@streamingsystem.com'],
        	['vendedor' => 'Nelly Furtado','telefono' => '98765456789', 'correo' => 'nelly@streamingsystem.com'],
        ]);
    }
}
