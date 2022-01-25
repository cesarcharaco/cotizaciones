<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TasasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        \DB::table('tasas')->insert([
        	'tasa' => 858,
        	'moneda' => 'Dolar',
        	'fecha' => date('Y-m-d')
        ]);

        \DB::table('tasa_ivas')->insert([
        	'tasa_i' => 19,
        	'fecha_i' => date('Y-m-d')
        ]);
    }
}
