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
        ])->assignRole('Administrador general');
        User::create([
            'name' => 'jefa-region',
            'email' => 'jefa-region.tecoatl@gmail.com',
            'password' => bcrypt('jefa-region'),
        ])->assignRole('Jefa de sub-departamento técnico');
        User::create([
            'name' => 'coordinador-aves',
            'email' => 'coordinador-aves.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-murcielagos',
            'email' => 'coordinador-murcielagos.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-mariposas',
            'email' => 'coordinador-mariposas.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-impacto',
            'email' => 'coordinador-impacto.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-prospectivos',
            'email' => 'coordinador-prospectivos.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-informes',
            'email' => 'coordinador-informes.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-campo',
            'email' => 'coordinador-campo.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-rescate',
            'email' => 'coordinador-rescate.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-ambiental',
            'email' => 'coordinador-ambiental.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-justificativo',
            'email' => 'coordinador-justificativo.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'vicko8148',
            'email' => 'vicko8148.tecoatl@gmail.com',
            'password' => bcrypt('Vicko8148'),
            'phone' => '9516129964'
        ])->assignRole('Coordinador de sub-área');
    }
}
