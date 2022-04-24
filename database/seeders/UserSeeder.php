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
            'phone' => '+529516129964'
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
            'phone' => '+529513642226'
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
            'name' => 'Víctor Rodríguez',
            'email' => 'victor.tecoatl@gmail.com',
            'password' => bcrypt('vicko8148'),
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'jefa-administrativa',
            'email' => 'jefa-administrativa.tecoatl@gmail.com',
            'password' => bcrypt('jefa-admin'),
        ])->assignRole('Jefa administrativa');
        User::create([
            'name' => 'jefa-compras',
            'email' => 'jefa-compras.tecoatl@gmail.com',
            'password' => bcrypt('jefa-compras'),
        ])->assignRole('Jefa subadministrativa');
    }
}
