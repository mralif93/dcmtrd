<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FacilityInformation;

class FacilityInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FacilityInformation::factory()->count(5)->create();
    }
}