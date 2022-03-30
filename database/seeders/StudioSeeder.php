<?php

namespace Database\Seeders;

use App\Models\Study;
use Illuminate\Database\Seeder;

class StudioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Study::create([
            'name' => 'Monitoreo de aves',
        ]);
        Study::create([
            'name' => 'Monitoreo de mariposas',
        ]);
        Study::create([
            'name' => 'Monitoreo de murciélagos',
        ]);
        Study::create([
            'name' => 'Supervisión ambiental',
        ]);
        Study::create([
            'name' => 'Técnico justificativo',
        ]);
    }
}
