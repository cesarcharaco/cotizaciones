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
            'email' => 'admin@comerciaboreal.cl',
            'password' => bcrypt('Admin2022.'),
            'user_type' => 'Admin',
        ]);
        
            
        \DB::table('users')->insert([
            'name' => 'Fernando Olivares',
            'email' => 'fernando@comerciaboreal.cl',
            'password' => bcrypt('Fernando2022.'),
            'user_type' => 'Cotizador',
        ]);
        
        \DB::table('users')->insert([
            'name' => 'Daniel Olivares',
            'email' => 'daniel@comerciaboreal.cl',
            'password' => bcrypt('Daniel2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Guillermo Olivares',
            'email' => 'guillermo@comerciaboreal.cl',
            'password' => bcrypt('Guillermo2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Rodrigo Tapia',
            'email' => 'rodrigo@comerciaboreal.cl',
            'password' => bcrypt('Rodrigo2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Felipe Tapia',
            'email' => 'felipe@comerciaboreal.cl',
            'password' => bcrypt('Felipe2022.'),
            'user_type' => 'Cotizador',
        ]);/*
        \DB::table('users')->insert([
            'name' => 'Janneth Jackson',
            'email' => 'janneth@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Alejandro Fernandez',
            'email' => 'alejandro@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Thalia Motola',
            'email' => 'thalia@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Bruno Mars',
            'email' => 'bruno@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Adele',
            'email' => 'adele@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'James Blunt',
            'email' => 'james@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Nelly Furtado',
            'email' => 'nelly@comerciaboreal.cl',
            'password' => bcrypt('2022.'),
            'user_type' => 'Cotizador',
        ]);*/

    }
}
