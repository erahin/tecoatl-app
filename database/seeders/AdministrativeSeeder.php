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
        Storage::disk('s3')->deleteDirectory('administrativo');
        Storage::disk('s3')->makeDirectory('administrativo');
        Storage::disk('s3')->makeDirectory('administrativo/1');
        Storage::disk('s3')->makeDirectory('administrativo/2');
        Storage::disk('s3')->makeDirectory('administrativo/3');
        Storage::disk('s3')->makeDirectory('administrativo/4');
        Storage::disk('s3')->makeDirectory('administrativo/5');
    }
}
