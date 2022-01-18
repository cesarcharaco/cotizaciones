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
            'email' => 'admin@streamingsystem.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Admin',
        ]);
        \DB::table('users')->insert([
            'name' => 'Michael',
            'email' => 'michael@streamingsystem.com',
            'password' => bcrypt('123456'),
            'user_type' => 'Vendedor',
        ]);

    }
}
