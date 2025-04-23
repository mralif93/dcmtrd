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
            BondsSeeder::class,
            DefaultReitsSeeder::class,
            PortfolioSeeder::class,
            PropertySeeder::class,
            TenantSeeder::class,
            LeaseSeeder::class,
            FinancialSeeder::class,
            SiteVisitSeeder::class,
        ]);
    }
}
