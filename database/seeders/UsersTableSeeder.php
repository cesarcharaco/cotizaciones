<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@comercialboreal.cl',
            'password' => bcrypt('Admin2022.'),
            'user_type' => 'Admin',
        ]);
        
            
        \DB::table('users')->insert([
            'name' => 'Fernando Olivares',
            'email' => 'fernando@comercialboreal.cl',
            'password' => bcrypt('Fernando2022.'),
            'user_type' => 'Cotizador',
        ]);
        
        \DB::table('users')->insert([
            'name' => 'Daniel Olivares',
            'email' => 'daniel@comercialboreal.cl',
            'password' => bcrypt('Daniel2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Guillermo Olivares',
            'email' => 'guillermo@comercialboreal.cl',
            'password' => bcrypt('Guillermo2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Rodrigo Tapia',
            'email' => 'rodrigo@comercialboreal.cl',
            'password' => bcrypt('Rodrigo2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Felipe Tapia',
            'email' => 'felipe@comercialboreal.cl',
            'password' => bcrypt('Felipe2022.'),
            'user_type' => 'Cotizador',
        ]);/*
        \DB::table('users')->insert([
            'name' => 'Janneth Jackson',
            'email' => 'janneth@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Alejandro Fernandez',
            'email' => 'alejandro@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Thalia Motola',
            'email' => 'thalia@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Bruno Mars',
            'email' => 'bruno@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Adele',
            'email' => 'adele@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'James Blunt',
            'email' => 'james@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Nelly Furtado',
            'email' => 'nelly@comercialboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);*/

    }
}
