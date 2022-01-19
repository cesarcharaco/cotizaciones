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
            'email' => 'admin@cotizaciones.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Admin',
        ]);
        
            
        \DB::table('users')->insert([
            'name' => 'Justin Beaber',
            'email' => 'justin@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        
        \DB::table('users')->insert([
            'name' => 'Shakira Mebarak',
            'email' => 'shakira@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Chester Benintong',
            'email' => 'chester@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Jon Bon Jovi',
            'email' => 'bonjovi@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Michael Jackson',
            'email' => 'michael@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Janneth Jackson',
            'email' => 'janneth@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Alejandro Fernandez',
            'email' => 'alejandro@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Thalia Motola',
            'email' => 'thalia@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Bruno Mars',
            'email' => 'bruno@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Adele',
            'email' => 'adele@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'James Blunt',
            'email' => 'james@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);
        \DB::table('users')->insert([
            'name' => 'Nelly Furtado',
            'email' => 'nelly@cotizacionesboreal.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Cotizador',
        ]);

    }
}
