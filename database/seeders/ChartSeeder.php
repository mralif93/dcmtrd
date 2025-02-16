<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chart;
use App\Models\Bond;

class ChartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bonds = Bond::all();

        foreach ($bonds as $bond) {
            Chart::factory()->count(2)->create([
                'bond_id' => $bond->id,
            ]);
        }
    }
}