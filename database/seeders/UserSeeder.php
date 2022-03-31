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
            'user_key' => 'OTwLR0UlJN'
        ])->assignRole('Administrador general');
        User::create([
            'name' => 'jefa-region',
            'email' => 'jefa-region.tecoatl@gmail.com',
            'password' => bcrypt('jefa-region'),
            'user_key' => 'ZyNTHF7XRw'
        ])->assignRole('Jefa de sub-departamento técnico');
        User::create([
            'name' => 'coordinador-aves',
            'email' => 'coordinador-aves.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'bimEUkmLgW'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-murcielagos',
            'email' => 'coordinador-murcielagos.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'qmpbkKNEu5'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-mariposas',
            'email' => 'coordinador-mariposas.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => '4yvnh3vbdL'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-impacto',
            'email' => 'coordinador-impacto.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'C4s6mcO1i4'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-prospectivos',
            'email' => 'coordinador-prospectivos.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'dMgtPJ80Uy'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-informes',
            'email' => 'coordinador-informes.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'ug28mZidz0'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-campo',
            'email' => 'coordinador-campo.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'BWJXohNfxI'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-rescate',
            'email' => 'coordinador-rescate.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'q4CfFqIIkf'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-ambiental',
            'email' => 'coordinador-ambiental.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'fNy9kpeCJk'
        ])->assignRole('Coordinador de sub-área');
        User::create([
            'name' => 'coordinador-justificativo',
            'email' => 'coordinador-justificativo.tecoatl@gmail.com',
            'password' => bcrypt('operativo'),
            'user_key' => 'iFnvnQTPD4'
        ])->assignRole('Coordinador de sub-área');
    }
}
