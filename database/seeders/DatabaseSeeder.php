<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DefaultUsersSeeder::class,
            IssuerSeeder::class,
            BondSeeder::class,
            BondInfoSeeder::class,
            RatingMovementSeeder::class,
            PaymentScheduleSeeder::class,
            RedemptionSeeder::class,
            CallScheduleSeeder::class,
            LockoutPeriodSeeder::class,
            TradingActivitySeeder::class,
            AnnouncementSeeder::class,
            FacilityInformationSeeder::class,
            RelatedDocumentSeeder::class,
            ChartSeeder::class,
        ]);
    }
}
