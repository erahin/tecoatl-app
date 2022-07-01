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
        Storage::disk('s3')->deleteDirectory('Legal');
        Storage::disk('s3')->makeDirectory('Legal');
        Storage::disk('s3')->makeDirectory('Legal/Corporativa');
        Storage::disk('s3')->makeDirectory('Legal/Operativa');
    }
}
