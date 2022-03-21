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
        ])->assignRole('Super usuario');
        User::create([
            'name' => 'jefa-region',
            'email' => 'jefa-region.tecoatl@gmail.com',
            'password' => bcrypt('jefa-region'),
        ])->assignRole('Jefa de sub-departamento técnico');
        User::create([
            'name' => 'operativo',
            'email' => 'operativo.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
    }
}
