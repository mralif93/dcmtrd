<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReitsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Financial Types
        $financialTypes = [
            ['name' => 'Loan', 'description' => 'Standard bank loan'],
            ['name' => 'Mortgage', 'description' => 'Property mortgage'],
            ['name' => 'Line of Credit', 'description' => 'Revolving credit facility']
        ];
        
        foreach ($financialTypes as $type) {
            DB::table('financial_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Banks
        $banks = [
            ['name' => 'First National Bank', 'description' => 'Major commercial bank'],
            ['name' => 'City Trust', 'description' => 'Local financial institution'],
            ['name' => 'Global Finance', 'description' => 'International banking corporation']
        ];
        
        foreach ($banks as $bank) {
            DB::table('banks')->insert([
                'name' => $bank['name'],
                'description' => $bank['description'],
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Portfolio Types
        $portfolioTypes = [
            ['name' => 'Residential', 'description' => 'Residential property investments'],
            ['name' => 'Commercial', 'description' => 'Commercial property investments'],
            ['name' => 'Mixed Use', 'description' => 'Combined residential and commercial properties']
        ];
        
        foreach ($portfolioTypes as $type) {
            DB::table('portfolio_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Portfolios
        $portfolios = [
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'Downtown Residences',
                'annual_report' => 'reports/downtown_2024.pdf',
                'status' => 'active'
            ],
            [
                'portfolio_types_id' => 2,
                'portfolio_name' => 'Business Park Holdings',
                'annual_report' => 'reports/business_park_2024.pdf',
                'status' => 'active'
            ],
            [
                'portfolio_types_id' => 3,
                'portfolio_name' => 'Urban Development Project',
                'annual_report' => 'reports/urban_dev_2024.pdf',
                'status' => 'active'
            ]
        ];
        
        foreach ($portfolios as $portfolio) {
            DB::table('portfolios')->insert(array_merge($portfolio, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Properties
        $properties = [
            [
                'portfolio_id' => 1,
                'category' => 'Apartment',
                'batch_no' => 'R-2025-001',
                'name' => 'Sunset Apartments',
                'address' => '123 Main Street',
                'city' => 'Metropolis',
                'state' => 'State',
                'country' => 'Country',
                'postal_code' => '12345',
                'land_size' => 2500.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Residential',
                'value' => 4500000.00,
                'ownership' => 'Full',
                'share_amount' => 4500000.00,
                'market_value' => 4800000.00,
                'status' => 'active'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Office',
                'batch_no' => 'C-2025-001',
                'name' => 'Tech Tower',
                'address' => '456 Business Avenue',
                'city' => 'Techville',
                'state' => 'State',
                'country' => 'Country',
                'postal_code' => '54321',
                'land_size' => 5000.00,
                'gross_floor_area' => 25000.00,
                'usage' => 'Commercial',
                'value' => 8500000.00,
                'ownership' => 'Full',
                'share_amount' => 8500000.00,
                'market_value' => 9000000.00,
                'status' => 'active'
            ],
            [
                'portfolio_id' => 3,
                'category' => 'Mixed',
                'batch_no' => 'M-2025-001',
                'name' => 'City Center Complex',
                'address' => '789 Urban Street',
                'city' => 'Centralville',
                'state' => 'State',
                'country' => 'Country',
                'postal_code' => '67890',
                'land_size' => 8000.00,
                'gross_floor_area' => 40000.00,
                'usage' => 'Mixed Use',
                'value' => 12000000.00,
                'ownership' => 'Partial',
                'share_amount' => 7200000.00,
                'market_value' => 12500000.00,
                'status' => 'active'
            ]
        ];
        
        foreach ($properties as $property) {
            DB::table('properties')->insert(array_merge($property, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Checklists
        $checklists = [
            [
                'property_id' => 1,
                'type' => 'Safety Inspection',
                'description' => 'Annual fire safety check',
                'approval_date' => Carbon::now()->subMonths(2),
                'status' => 'approved'
            ],
            [
                'property_id' => 2,
                'type' => 'Electrical Inspection',
                'description' => 'Wiring and electrical systems check',
                'approval_date' => Carbon::now()->subMonths(1),
                'status' => 'approved'
            ],
            [
                'property_id' => 3,
                'type' => 'Structural Assessment',
                'description' => 'Building structure evaluation',
                'approval_date' => Carbon::now()->addMonths(1),
                'status' => 'pending'
            ]
        ];
        
        foreach ($checklists as $checklist) {
            DB::table('checklists')->insert(array_merge($checklist, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Tenants
        $tenants = [
            [
                'property_id' => 1,
                'name' => 'John Smith',
                'contact_person' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '123-456-7890',
                'commencement_date' => Carbon::now()->subYears(1),
                'expiry_date' => Carbon::now()->addYears(1),
                'status' => 'active'
            ],
            [
                'property_id' => 2,
                'name' => 'Tech Innovations Inc.',
                'contact_person' => 'Jane Doe',
                'email' => 'jane.doe@techinnovations.com',
                'phone' => '987-654-3210',
                'commencement_date' => Carbon::now()->subMonths(6),
                'expiry_date' => Carbon::now()->addYears(2),
                'status' => 'active'
            ],
            [
                'property_id' => 3,
                'name' => 'Urban Living Co.',
                'contact_person' => 'Michael Johnson',
                'email' => 'michael@urbanliving.co',
                'phone' => '555-123-4567',
                'commencement_date' => Carbon::now()->subMonths(3),
                'expiry_date' => Carbon::now()->addYears(3),
                'status' => 'active'
            ]
        ];
        
        foreach ($tenants as $tenant) {
            DB::table('tenants')->insert(array_merge($tenant, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Leases
        $leases = [
            [
                'tenant_id' => 1,
                'lease_name' => 'Residential Lease Agreement',
                'demised_premises' => 'Apartment 101, Sunset Apartments',
                'permitted_use' => 'Residential dwelling',
                'rental_amount' => 2500.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '2',
                'start_date' => Carbon::now()->subYears(1),
                'end_date' => Carbon::now()->addYears(1),
                'status' => 'active'
            ],
            [
                'tenant_id' => 2,
                'lease_name' => 'Commercial Office Lease',
                'demised_premises' => '5th Floor, Tech Tower',
                'permitted_use' => 'Office space',
                'rental_amount' => 15000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '3',
                'start_date' => Carbon::now()->subMonths(6),
                'end_date' => Carbon::now()->addYears(2)->addMonths(6),
                'status' => 'active'
            ],
            [
                'tenant_id' => 3,
                'lease_name' => 'Mixed Use Development Lease',
                'demised_premises' => 'Units 1-5, City Center Complex',
                'permitted_use' => 'Retail and residential',
                'rental_amount' => 25000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => Carbon::now()->subMonths(3),
                'end_date' => Carbon::now()->addYears(4)->addMonths(9),
                'status' => 'active'
            ]
        ];
        
        foreach ($leases as $lease) {
            DB::table('leases')->insert(array_merge($lease, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Financials
        $financials = [
            [
                'portfolio_id' => 1,
                'bank_id' => 1,
                'financial_type_id' => 2,
                'purpose' => 'Property acquisition',
                'tenure' => '20 years',
                'installment_date' => Carbon::now()->day(15),
                'profit_type' => 'Fixed',
                'profit_rate' => 4.5000,
                'process_fee' => 25000.00,
                'total_facility_amount' => 3500000.00,
                'utilization_amount' => 3500000.00,
                'outstanding_amount' => 3200000.00,
                'interest_monthly' => 12000.00,
                'security_value_monthly' => 14500.00,
                'facilities_agent' => 'Financial Services Group',
                'agent_contact' => 'agent@financialservices.com',
                'valuer' => 'Property Valuation Co.',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 2,
                'bank_id' => 2,
                'financial_type_id' => 1,
                'purpose' => 'Renovation',
                'tenure' => '5 years',
                'installment_date' => Carbon::now()->day(1),
                'profit_type' => 'Variable',
                'profit_rate' => 5.2500,
                'process_fee' => 15000.00,
                'total_facility_amount' => 1500000.00,
                'utilization_amount' => 1200000.00,
                'outstanding_amount' => 1000000.00,
                'interest_monthly' => 4375.00,
                'security_value_monthly' => 5000.00,
                'facilities_agent' => 'Business Loan Agency',
                'agent_contact' => 'contact@businessloan.com',
                'valuer' => 'Commercial Valuation Experts',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 3,
                'bank_id' => 3,
                'financial_type_id' => 3,
                'purpose' => 'Development',
                'tenure' => '10 years',
                'installment_date' => Carbon::now()->day(10),
                'profit_type' => 'Fixed',
                'profit_rate' => 4.7500,
                'process_fee' => 30000.00,
                'total_facility_amount' => 8000000.00,
                'utilization_amount' => 6000000.00,
                'outstanding_amount' => 5800000.00,
                'interest_monthly' => 22916.67,
                'security_value_monthly' => 25000.00,
                'facilities_agent' => 'Global Development Finance',
                'agent_contact' => 'finance@globaldev.com',
                'valuer' => 'Urban Property Assessors',
                'status' => 'active'
            ]
        ];
        
        foreach ($financials as $financial) {
            DB::table('financials')->insert(array_merge($financial, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Site Visits
        $siteVisits = [
            [
                'property_id' => 1,
                'date_visit' => Carbon::now()->addDays(7),
                'time_visit' => '10:00:00',
                'inspector_name' => 'Robert Brown',
                'notes' => 'Regular annual inspection',
                'attachment' => null,
                'status' => 'scheduled'
            ],
            [
                'property_id' => 2,
                'date_visit' => Carbon::now()->subDays(14),
                'time_visit' => '14:30:00',
                'inspector_name' => 'Sarah Johnson',
                'notes' => 'Post-renovation inspection completed',
                'attachment' => 'visits/tech_tower_inspection.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 3,
                'date_visit' => Carbon::now()->addDays(21),
                'time_visit' => '09:15:00',
                'inspector_name' => 'David Wilson',
                'notes' => 'Structural assessment follow-up',
                'attachment' => null,
                'status' => 'scheduled'
            ]
        ];
        
        foreach ($siteVisits as $visit) {
            DB::table('site_visits')->insert(array_merge($visit, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}