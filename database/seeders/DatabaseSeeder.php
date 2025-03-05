<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\PortfolioSeeder;
use Database\Seeders\DefaultUsersSeeder;
use Database\Seeders\PortfolioTypeSeeder;
use Database\Seeders\TenantSeeder;
use Database\Seeders\LeaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            DefaultUsersSeeder::class,
            PortfolioTypeSeeder::class,
            PortfolioSeeder::class,
            PropertySeeder::class,
            TenantSeeder::class,
            LeaseSeeder::class,
        ]);
    }
}
