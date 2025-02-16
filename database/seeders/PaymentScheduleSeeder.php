<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentSchedule;
use App\Models\Bond;

class PaymentScheduleSeeder extends Seeder
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
            PaymentSchedule::factory()->count(3)->create([
                'bond_id' => $bond->id,
            ]);
        }
    }
}