<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('productos')->insert([
        	['codigo' => '20210727RELRT45',
        	'detalles' => 'RELOJ INTELIGENTE',
        	'marca' => 'LG',
        	'modelo' => 'XR2',
        	'color' => 'NEGRO',
        	'id_categoria' => 1,
        	'status' => 'Activo'],

        	['codigo' => '20210727TABRT45',
        	'detalles' => 'TABLET INTELIGENTE',
        	'marca' => 'SAMSUM',
        	'modelo' => 'TB3',
        	'color' => 'GRIS',
        	'id_categoria' => 5,
        	'status' => 'Activo'],

            ['codigo' => '20210727CONST45',
            'detalles' => 'PALA CABO MADERA',
            'marca' => 'TOR',
            'modelo' => 'TB3',
            'color' => 'MARRON',
            'id_categoria' => 6,
            'status' => 'Activo']
        ]);
        \DB::table('imagenes')->insert([
            ['id_producto' => 3, 'nombre' => '2302428_pala.jpg','url' => 'img_productos/2302428_pala.jpg'],
            ['id_producto' => 2, 'nombre' => '121414_tablet.jpg','url' => 'img_productos/121414_tablet.jpg'],
            ['id_producto' => 1, 'nombre' => '26341713_reloj.jpg','url' => 'img_productos/26341713_reloj.jpg']
        ]);

        
    }
}
