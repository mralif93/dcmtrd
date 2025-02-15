<?php

namespace Database\Seeders;

use App\Models\Bond;
use App\Models\Chart;
use Illuminate\Database\Seeder;

class ChartSeeder extends Seeder
{
    public function run()
    {
        // Create 2-3 charts per bond
        foreach (Bond::all() as $bond) {
            Chart::factory()
                ->count(rand(2, 3))
                ->create(['bond_id' => $bond->id]);
        }
    }
}