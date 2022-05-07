<?php

namespace Database\Seeders;

use App\Models\Legal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class LegalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Legal::create([
            'name' => 'Corporativa',
        ]);
        Legal::create([
            'name' => 'Operativa',
        ]);
        Storage::disk('s3')->deleteDirectory('legal');
        Storage::disk('s3')->makeDirectory('legal');
        Storage::disk('s3')->makeDirectory('legal/Corporativa');
        Storage::disk('s3')->makeDirectory('legal/Operativa');
    }
}
