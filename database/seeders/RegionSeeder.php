<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

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
    }
}
