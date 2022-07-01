<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Storage::disk('s3')->deleteDirectory('Tecnico/');
        Storage::disk('s3')->makeDirectory('Tecnico/centro');
        Storage::disk('s3')->makeDirectory('Tecnico/norte');
        Storage::disk('s3')->makeDirectory('Tecnico/sur');
        Region::create([
            'name' => 'Norte',
        ]);
        Region::create([
            'name' => 'Sur',
        ]);
        Region::create([
            'name' => 'Centro',
        ]);
    }
}
