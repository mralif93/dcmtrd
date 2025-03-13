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

        // Seed Updated Checklists with new fields
        $checklists = [
            [
                'property_id' => 1,
                'type' => 'documentation',
                'description' => 'Legal documentation verification',
                'approval_date' => Carbon::now()->subMonths(2),
                'status' => 'completed',
                'assigned_department' => 'LD',
                'verifying_department' => 'OD',
                'response_time_days' => 3,
                'prepared_by' => 'Dang Fathihah binti Ibrahim',
                'prepared_date' => Carbon::now()->subMonths(2)->subDays(5),
                'confirmed_by' => 'Roslim Syah bin Idris',
                'confirmed_date' => Carbon::now()->subMonths(2)
            ],
            [
                'property_id' => 2,
                'type' => 'tenant',
                'description' => 'Tenant renewal verification',
                'approval_date' => Carbon::now()->subMonths(1),
                'status' => 'completed',
                'assigned_department' => 'OD',
                'verifying_department' => 'LD',
                'response_time_days' => 3,
                'prepared_by' => 'Ahmad Rizal bin Hassan',
                'prepared_date' => Carbon::now()->subMonths(1)->subDays(7),
                'confirmed_by' => 'Lim Wei Ling',
                'confirmed_date' => Carbon::now()->subMonths(1)
            ],
            [
                'property_id' => 3,
                'type' => 'condition',
                'description' => 'Property condition assessment',
                'approval_date' => null,
                'status' => 'pending',
                'assigned_department' => 'OD',
                'verifying_department' => null,
                'response_time_days' => null,
                'prepared_by' => null,
                'prepared_date' => null,
                'confirmed_by' => null,
                'confirmed_date' => null
            ]
        ];
        
        foreach ($checklists as $checklist) {
            DB::table('checklists')->insert(array_merge($checklist, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }

        // Seed Tenants with approval fields
        $tenants = [
            [
                'property_id' => 1,
                'name' => 'John Smith',
                'contact_person' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '123-456-7890',
                'commencement_date' => Carbon::now()->subYears(1),
                'approval_date' => Carbon::now()->subYears(1)->subDays(15),
                'expiry_date' => Carbon::now()->addYears(1),
                'status' => 'active',
                'approval_status' => 'approved',
                'last_approval_date' => Carbon::now()->subYears(1)->subDays(15)
            ],
            [
                'property_id' => 2,
                'name' => 'Tech Innovations Inc.',
                'contact_person' => 'Jane Doe',
                'email' => 'jane.doe@techinnovations.com',
                'phone' => '987-654-3210',
                'commencement_date' => Carbon::now()->subMonths(6),
                'approval_date' => Carbon::now()->subMonths(6)->subDays(10),
                'expiry_date' => Carbon::now()->addYears(2),
                'status' => 'active',
                'approval_status' => 'approved',
                'last_approval_date' => Carbon::now()->subMonths(6)->subDays(10)
            ],
            [
                'property_id' => 3,
                'name' => 'Urban Living Co.',
                'contact_person' => 'Michael Johnson',
                'email' => 'michael@urbanliving.co',
                'phone' => '555-123-4567',
                'commencement_date' => Carbon::now()->subMonths(3),
                'approval_date' => Carbon::now()->subMonths(3)->subDays(7),
                'expiry_date' => Carbon::now()->addYears(3),
                'status' => 'active',
                'approval_status' => 'approved',
                'last_approval_date' => Carbon::now()->subMonths(3)->subDays(7)
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

        // Seed Site Visits (updated with checklist_id)
        $siteVisits = [
            [
                'property_id' => 1,
                'checklist_id' => 1,
                'date_visit' => Carbon::now()->subMonths(2)->subDays(5),
                'time_visit' => '10:00:00',
                'inspector_name' => 'Robert Brown',
                'notes' => 'Documentation verification visit',
                'attachment' => null,
                'status' => 'completed'
            ],
            [
                'property_id' => 2,
                'checklist_id' => 2,
                'date_visit' => Carbon::now()->subMonths(1)->subDays(7),
                'time_visit' => '14:30:00',
                'inspector_name' => 'Sarah Johnson',
                'notes' => 'Tenant renewal verification completed',
                'attachment' => 'visits/tech_tower_inspection.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 3,
                'checklist_id' => 3,
                'date_visit' => Carbon::now()->addDays(7),
                'time_visit' => '09:15:00',
                'inspector_name' => 'David Wilson',
                'notes' => 'Upcoming property condition assessment',
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
        
        // NEW SEEDS FOR CHECKLIST-RELATED TABLES
        
        // Seed Documentation Items
        $documentationItems = [
            [
                'checklist_id' => 1,
                'item_number' => '1.1',
                'document_type' => 'Title',
                'description' => 'H.S (D) 221754 Lot PT 254356 Bandar Ipoh, Daerah Kinta, Negeri Perak',
                'validity_date' => null,
                'location' => 'Title with Maybank Investment Berhad',
                'is_prefilled' => true
            ],
            [
                'checklist_id' => 1,
                'item_number' => '1.2',
                'document_type' => 'Trust Deed',
                'description' => 'Second Restated Trust Deed dated 25/11/2019 & the supplemental to the second restated trust deed dated 29/12/2022',
                'validity_date' => Carbon::parse('2022-12-29'),
                'location' => 'LD\'s room',
                'is_prefilled' => true
            ],
            [
                'checklist_id' => 1,
                'item_number' => '1.4',
                'document_type' => 'Lease Agreement',
                'description' => 'Lease Agreement dated 22/06/2021',
                'validity_date' => Carbon::parse('2021-06-22'),
                'location' => 'LD\'s room',
                'is_prefilled' => true
            ],
            [
                'checklist_id' => 1,
                'item_number' => '1.6',
                'document_type' => 'Maintenance Manager Agreement',
                'description' => 'Maintanece Management Agreement dated 11/03/2013, Supplemental to the Maintenance Management dated 30/03/2018 & Renewed by Extension Maintenance Management Agreement dated 15/12/2021',
                'validity_date' => Carbon::parse('2021-12-15'),
                'location' => 'LD\'s room',
                'is_prefilled' => true
            ],
        ];
        
        foreach ($documentationItems as $item) {
            DB::table('documentation_items')->insert(array_merge($item, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
        
        // Seed Tenant Approvals
        $tenantApprovals = [
            [
                'checklist_id' => 2,
                'tenant_id' => 2,
                'lease_id' => 2,
                'approval_type' => 'renewal',
                'od_approved' => true,
                'ld_verified' => true,
                'od_approval_date' => Carbon::now()->subMonths(1)->subDays(10),
                'ld_verification_date' => Carbon::now()->subMonths(1)->subDays(7),
                'notes' => 'Tenant renewal approved for Tech Innovations Inc.',
                'submitted_to_ld_date' => Carbon::now()->subMonths(1)->subDays(10),
                'ld_response_date' => Carbon::now()->subMonths(1)->subDays(7)
            ],
            [
                'checklist_id' => 3,
                'tenant_id' => 3,
                'lease_id' => 3,
                'approval_type' => 'new',
                'od_approved' => true,
                'ld_verified' => false,
                'od_approval_date' => Carbon::now()->subDays(5),
                'ld_verification_date' => null,
                'notes' => 'Awaiting LD verification for Urban Living Co.',
                'submitted_to_ld_date' => Carbon::now()->subDays(5),
                'ld_response_date' => null
            ]
        ];
        
        foreach ($tenantApprovals as $approval) {
            DB::table('tenant_approvals')->insert(array_merge($approval, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
        
        // Seed Condition Checks
        $conditionChecks = [
            // External Area checks for checklist 3
            [
                'checklist_id' => 3,
                'section' => 'External Area',
                'item_number' => '3.1',
                'item_name' => 'General Cleanliness',
                'is_satisfied' => true,
                'remarks' => null
            ],
            [
                'checklist_id' => 3,
                'section' => 'External Area',
                'item_number' => '3.2',
                'item_name' => 'Fencing & Main Gate',
                'is_satisfied' => true,
                'remarks' => null
            ],
            [
                'checklist_id' => 3,
                'section' => 'External Area',
                'item_number' => '3.3',
                'item_name' => 'External Facade',
                'is_satisfied' => true,
                'remarks' => null
            ],
            [
                'checklist_id' => 3,
                'section' => 'External Area',
                'item_number' => '3.4',
                'item_name' => 'Car park',
                'is_satisfied' => true,
                'remarks' => null
            ],
            [
                'checklist_id' => 3,
                'section' => 'External Area',
                'item_number' => '3.5',
                'item_name' => 'Land settlement',
                'is_satisfied' => false,
                'remarks' => 'N/A'
            ],
            
            // Internal Area checks for checklist 3
            [
                'checklist_id' => 3,
                'section' => 'Internal Area',
                'item_number' => '4.1',
                'item_name' => 'Door & window',
                'is_satisfied' => true,
                'remarks' => null
            ],
            [
                'checklist_id' => 3,
                'section' => 'Internal Area',
                'item_number' => '4.2',
                'item_name' => 'Staircase',
                'is_satisfied' => true,
                'remarks' => null
            ],
            [
                'checklist_id' => 3,
                'section' => 'Internal Area',
                'item_number' => '4.3',
                'item_name' => 'Toilet',
                'is_satisfied' => true,
                'remarks' => null
            ],
        ];
        
        foreach ($conditionChecks as $check) {
            DB::table('condition_checks')->insert(array_merge($check, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
        
        // Seed Property Improvements
        $propertyImprovements = [
            [
                'checklist_id' => 3,
                'item_number' => '5.4',
                'improvement_type' => 'Equipment Replacement',
                'sub_type' => 'Air condition/Chiller System/Air Handling Unit ("AHU")',
                'approval_date' => Carbon::parse('2022-12-14'),
                'scope_of_work' => 'Proposed Total Replacement and Disposal of one (1) unit of Air Handling Unit (AHU) for Cardiac Operation Theatre at 1st floor Block B',
                'status' => 'completed'
            ],
            [
                'checklist_id' => 3,
                'item_number' => '5.1',
                'improvement_type' => 'Development',
                'sub_type' => null,
                'approval_date' => null,
                'scope_of_work' => null,
                'status' => 'not_applicable'
            ],
            [
                'checklist_id' => 3,
                'item_number' => '5.2',
                'improvement_type' => 'Renovation',
                'sub_type' => null,
                'approval_date' => null,
                'scope_of_work' => null,
                'status' => 'not_applicable'
            ],
        ];
        
        foreach ($propertyImprovements as $improvement) {
            DB::table('property_improvements')->insert(array_merge($improvement, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
        
        // Seed Site Visit Logs
        $siteVisitLogs = [
            [
                'site_visit_id' => 1,
                'no' => 1,
                'visitation_date' => Carbon::parse('2025-02-02'),
                'purpose' => 'Approval for Proposed Total Replacement and Disposal for Two (2) Units Suction Water Pump No. 1 & No. 2',
                'status' => 'Completed',
                'report_submission_date' => Carbon::parse('2025-05-03'),
                'report_attachment' => 'SV_Report_KPJ_Ampang_Puteri.pdf',
                'follow_up_required' => false,
                'remarks' => 'NIL'
            ],
            [
                'site_visit_id' => 2,
                'no' => 2,
                'visitation_date' => Carbon::parse('2025-07-07'),
                'purpose' => 'To discharge ART\'s duty as the legal owner of the Al-Salām Reit properties',
                'status' => 'Pending',
                'report_submission_date' => null,
                'report_attachment' => null,
                'follow_up_required' => false,
                'remarks' => null
            ],
            [
                'site_visit_id' => 3,
                'no' => 3,
                'visitation_date' => Carbon::now()->addDays(7),
                'purpose' => 'Regular property assessment and tenant review',
                'status' => 'Scheduled',
                'report_submission_date' => null,
                'report_attachment' => null,
                'follow_up_required' => true,
                'remarks' => 'Will verify maintenance issues reported by tenants'
            ]
        ];
        
        foreach ($siteVisitLogs as $log) {
            DB::table('site_visit_logs')->insert(array_merge($log, [
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}