<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SolicitantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('empresas')->insert([
            ['nombre' => 'Mineria Candelaria',
             'rut' => '1111111111', 
             'descripcion' => 'mmmmmmmmmmmmmmmmmm'],

            ['nombre' => 'Mantos Verdes', 
            'rut' => '222222222222', 
            'descripcion' => 'ppppppppppppppp'],

            ['nombre' => 'Ojos del Salado', 
            'rut' => '33333333333333333333', 
            'descripcion' => 'qqqqqqqqqqqqqqqqqqqqqqqqqqqqq'],

            ['nombre' => 'Cerro Negro', 
            'rut' => '444444444444', 
            'descripcion' => 'xxxxxxxxxxxxxxxxxxxx']
        ]);
        \DB::table('solicitantes')->insert([
        	['nombres' => 'Bill',
        	 'apellidos' => 'Gate', 
        	 'celular' => '987654321', 
        	 'direccion' => 'Miami', 
        	 'localidad' => 'Beach',
             'id_empresa' => 1],

        	['nombres' => 'Will', 
        	'apellidos' => 'Smith', 
        	'celular' => '987654322', 
        	'direccion' => 'Los Angeles', 
        	'localidad' => 'Beverly Hills',
             'id_empresa' => 2],

        	['nombres' => 'Keanu', 
        	'apellidos' => 'Reeves', 
        	'celular' => '987654323', 
        	'direccion' => 'Orlando', 
        	'localidad' => 'Florida',
             'id_empresa' => 3],

        	['nombres' => 'Augusto', 
        	'apellidos' => 'Soto', 
        	'celular' => '987654324', 
        	'direccion' => 'Argentina', 
        	'localidad' => 'Morón',
             'id_empresa' => 4]
        ]);
    }
}
