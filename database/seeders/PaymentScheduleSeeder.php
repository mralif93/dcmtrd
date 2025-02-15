<?php

namespace Database\Seeders;

use App\Models\BondInfo;
use App\Models\PaymentSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PaymentScheduleSeeder extends Seeder
{
    public function run()
    {
        foreach (BondInfo::all() as $bondInfo) {
            // Generate 4-6 payment schedules per bond
            $numberOfSchedules = rand(4, 6);
            $startDate = Carbon::parse($bondInfo->issue_date);
            $maturityDate = Carbon::parse($bondInfo->maturity_date);

            // Calculate interval between schedules
            $totalMonths = $startDate->diffInMonths($maturityDate);
            $intervalMonths = ceil($totalMonths / $numberOfSchedules);

            for ($i = 0; $i < $numberOfSchedules; $i++) {
                $endDate = $startDate->copy()->addMonths($intervalMonths);
                
                // Ensure end date does not exceed maturity date
                if ($endDate->gt($maturityDate)) {
                    $endDate = $maturityDate;
                }

                PaymentSchedule::create([
                    'bond_info_id' => $bondInfo->id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'ex_date' => $endDate->copy()->subDays(7)->format('Y-m-d'), // 7 days before end_date
                    'coupon_rate' => $bondInfo->coupon_rate,
                    'adjustment_date' => (rand(1, 5) === 1) // 20% chance of having an adjustment
                        ? $startDate->copy()->addDays(rand(1, $startDate->diffInDays($endDate)))->format('Y-m-d')
                        : null,
                ]);

                $startDate = $endDate->copy()->addDay();

                // Break if the next start date exceeds maturity date
                if ($startDate->gt($maturityDate)) {
                    break;
                }
            }
        }
    }
}