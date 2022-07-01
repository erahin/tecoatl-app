<?php

namespace Database\Seeders;

use App\Models\Administrative;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AdministrativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Administrative::create([
            'name' => 'Auxiliar administrativo',
        ]);
        Administrative::create([
            'name' => 'Contable',
        ]);
        Administrative::create([
            'name' => 'Compras',
        ]);
        Administrative::create([
            'name' => 'Recursos humanos',
        ]);
        Administrative::create([
            'name' => 'Seguridad e higiene',
        ]);
        Storage::disk('s3')->deleteDirectory('Administrativo');
        Storage::disk('s3')->deleteDirectory('Publico');
        Storage::disk('s3')->makeDirectory('Publico');
        Storage::disk('s3')->makeDirectory('Directivo');
        Storage::disk('s3')->makeDirectory('Administrativo');
        Storage::disk('s3')->makeDirectory('Administrativo/1');
        Storage::disk('s3')->makeDirectory('Administrativo/2');
        Storage::disk('s3')->makeDirectory('Administrativo/3');
        Storage::disk('s3')->makeDirectory('Administrativo/4');
        Storage::disk('s3')->makeDirectory('Administrativo/5');
        Storage::disk('s3')->makeDirectory('Publico/Formatos');
        Storage::disk('s3')->makeDirectory('Publico/Fotografrías corporativas');
    }
}
