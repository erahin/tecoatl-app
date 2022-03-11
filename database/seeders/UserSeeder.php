<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'super-admin',
            'email' => 'super-admin.tecoatl@gmail.com',
            'password' => bcrypt('super-admin'),
        ])->assignRole('Super-user');
        User::create([
            'name' => 'Víctor Rodríguez',
            'email' => 'victor.tecoatl@gmail.com',
            'password' => bcrypt('vicko8148'),
        ])->assignRole('Admin');
        User::create([
            'name' => 'operativo',
            'email' => 'operativo.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Operator');
    }
}
