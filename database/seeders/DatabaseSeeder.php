<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\LeaseSeeder;
use Database\Seeders\IssuerSeeder;
use Database\Seeders\TenantSeeder;
use Database\Seeders\PropertySeeder;
use Database\Seeders\PortfolioSeeder;
use Database\Seeders\DefaultUsersSeeder;
use Database\Seeders\PortfolioTypeSeeder;

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

            PortfolioTypeSeeder::class,
            PortfolioSeeder::class,
            PropertySeeder::class,
            TenantSeeder::class,
            LeaseSeeder::class,
            // FinancialSeeder::class,
            // SiteVisitSeeder::class,
            // ChecklistSeeder::class,
            // ChecklistLegalDocumentationSeeder::class,
            // ChecklistTenantSeeder::class,
            // ChecklistExternalAreaConditionsSeeder::class,
            // ChecklistInternalAreaConditionsSeeder::class,
            // ChecklistDisposalInstallationsSeeder::class,
            // ChecklistPropertyDevelopmentsSeeder::class,
            // AppointmentSeeder::class,
            // ApprovalFormSeeder::class,
            // ApprovalPropertySeeder::class,
            // FinancialPropertySeeder::class,
            // SiteVisitLogSeeder::class,
        ]);
    }
}
