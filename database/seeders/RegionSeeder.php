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
        Region::create([
            'name' => 'Norte',
        ]);
        Region::create([
            'name' => 'Sur',
        ]);
        Region::create([
            'name' => 'Centro',
        ]);
        Storage::disk('s3')->deleteDirectory('tecnico/centro');
        Storage::disk('s3')->deleteDirectory('tecnico/norte');
        Storage::disk('s3')->deleteDirectory('tecnico/sur');
        Storage::disk('s3')->makeDirectory('tecnico/centro');
        Storage::disk('s3')->makeDirectory('tecnico/norte');
        Storage::disk('s3')->makeDirectory('tecnico/sur');
    }
}
