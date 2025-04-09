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
            ['name' => 'Islamic Banking Financing', 'description' => 'Shariah-compliant financing options'],
            ['name' => 'Conventional Loan', 'description' => 'Traditional interest-based financing'],
            ['name' => 'Revolving Credit', 'description' => 'Flexible credit line for ongoing needs'],
            ['name' => 'Term Loan', 'description' => 'Fixed-term loan with regular repayment schedule'],
            ['name' => 'Bridge Financing', 'description' => 'Short-term financing between transactions'],
            ['name' => 'Syndicated Loan', 'description' => 'Loan provided by a group of lenders'],
            ['name' => 'Mortgage', 'description' => 'Loan secured by real property'],
            ['name' => 'Construction Loan', 'description' => 'Financing for property development'],
            ['name' => 'Mezzanine Financing', 'description' => 'Subordinated debt or preferred equity'],
            ['name' => 'REIT Financing', 'description' => 'Funding through Real Estate Investment Trusts'],
            ['name' => 'Commercial Mortgage-Backed Securities', 'description' => 'Securities backed by commercial loans'],
            ['name' => 'Green Financing', 'description' => 'Funding for sustainable real estate projects'],
            ['name' => 'Commercial Paper', 'description' => 'Short-term debt instruments'],
            ['name' => 'Equity Financing', 'description' => 'Capital for ownership stake'],
            ['name' => 'Lease Financing', 'description' => 'Assets leased instead of purchased']
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
            ['name' => 'HSBC Bank', 'description' => 'Global banking and financial services'],
            ['name' => 'Citibank', 'description' => 'Multinational investment bank'],
            ['name' => 'JP Morgan Chase', 'description' => 'American financial services company'],
            ['name' => 'Bank of America', 'description' => 'American multinational bank'],
            ['name' => 'DBS Bank', 'description' => 'Banking corporation from Singapore'],
            ['name' => 'Standard Chartered', 'description' => 'British multinational bank'],
            ['name' => 'OCBC Bank', 'description' => 'Singapore-based banking organization'],
            ['name' => 'UOB Bank', 'description' => 'Singaporean multinational bank'],
            ['name' => 'Maybank', 'description' => 'Malaysian banking group'],
            ['name' => 'CIMB Bank', 'description' => 'Malaysian universal bank'],
            ['name' => 'RHB Bank', 'description' => 'Malaysian financial services provider'],
            ['name' => 'Bank Islam', 'description' => 'Malaysian Islamic banking institution'],
            ['name' => 'Public Bank', 'description' => 'Malaysian banking group'],
            ['name' => 'Hong Leong Bank', 'description' => 'Malaysian banking company'],
            ['name' => 'AmBank', 'description' => 'Malaysian banking services']
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
            ['name' => 'Mixed Use', 'description' => 'Combined residential and commercial properties'],
            ['name' => 'Retail', 'description' => 'Retail property investments'],
            ['name' => 'Industrial', 'description' => 'Industrial property investments'],
            ['name' => 'Office', 'description' => 'Office property investments'],
            ['name' => 'Hospitality', 'description' => 'Hotel and resort investments'],
            ['name' => 'Healthcare', 'description' => 'Medical and healthcare facilities'],
            ['name' => 'Educational', 'description' => 'Schools and educational institutions'],
            ['name' => 'Logistics', 'description' => 'Warehousing and distribution centers'],
            ['name' => 'Data Centers', 'description' => 'IT infrastructure facilities'],
            ['name' => 'Self Storage', 'description' => 'Self-storage facilities'],
            ['name' => 'Agricultural', 'description' => 'Agricultural land investments'],
            ['name' => 'Leisure', 'description' => 'Recreation and leisure facilities'],
            ['name' => 'Student Housing', 'description' => 'Purpose-built student accommodations']
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
                'portfolio_types_id' => 1, // Residential
                'portfolio_name' => 'Skyline Residences',
                'annual_report' => 'reports/skyline_annual_2024.pdf',
                'trust_deed_document' => 'legal/skyline_trust_deed.pdf',
                'insurance_document' => 'insurance/skyline_policy.pdf',
                'valuation_report' => 'valuation/skyline_q4_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 2, // Commercial
                'portfolio_name' => 'Downtown Business Center',
                'annual_report' => 'reports/dbc_annual_2024.pdf',
                'trust_deed_document' => 'legal/dbc_trust_deed.pdf',
                'insurance_document' => 'insurance/dbc_policy.pdf',
                'valuation_report' => 'valuation/dbc_q3_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 3, // Mixed Use
                'portfolio_name' => 'Urban Complex',
                'annual_report' => 'reports/urban_annual_2024.pdf',
                'trust_deed_document' => 'legal/urban_trust_deed.pdf',
                'insurance_document' => 'insurance/urban_policy.pdf',
                'valuation_report' => 'valuation/urban_q2_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 4, // Retail
                'portfolio_name' => 'Central Shopping Mall',
                'annual_report' => 'reports/csm_annual_2024.pdf',
                'trust_deed_document' => 'legal/csm_trust_deed.pdf',
                'insurance_document' => 'insurance/csm_policy.pdf',
                'valuation_report' => 'valuation/csm_q1_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 5, // Industrial
                'portfolio_name' => 'Tech Industrial Park',
                'annual_report' => 'reports/tip_annual_2024.pdf',
                'trust_deed_document' => 'legal/tip_trust_deed.pdf',
                'insurance_document' => 'insurance/tip_policy.pdf',
                'valuation_report' => 'valuation/tip_q4_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 6, // Office
                'portfolio_name' => 'Executive Tower',
                'annual_report' => 'reports/et_annual_2024.pdf',
                'trust_deed_document' => 'legal/et_trust_deed.pdf',
                'insurance_document' => 'insurance/et_policy.pdf',
                'valuation_report' => 'valuation/et_q3_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 7, // Hospitality
                'portfolio_name' => 'Luxury Resort Collection',
                'annual_report' => 'reports/lrc_annual_2024.pdf',
                'trust_deed_document' => 'legal/lrc_trust_deed.pdf',
                'insurance_document' => 'insurance/lrc_policy.pdf',
                'valuation_report' => 'valuation/lrc_q2_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 8, // Healthcare
                'portfolio_name' => 'Medical Plaza',
                'annual_report' => 'reports/mp_annual_2024.pdf',
                'trust_deed_document' => 'legal/mp_trust_deed.pdf',
                'insurance_document' => 'insurance/mp_policy.pdf',
                'valuation_report' => 'valuation/mp_q1_2024.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 9, // Educational
                'portfolio_name' => 'Campus Properties',
                'annual_report' => 'reports/cp_annual_2024.pdf',
                'trust_deed_document' => 'legal/cp_trust_deed.pdf',
                'insurance_document' => 'insurance/cp_policy.pdf',
                'valuation_report' => 'valuation/cp_q4_2023.pdf',
                'status' => 'Draft'
            ],
            [
                'portfolio_types_id' => 10, // Logistics
                'portfolio_name' => 'Distribution Hub',
                'annual_report' => 'reports/dh_annual_2024.pdf',
                'trust_deed_document' => 'legal/dh_trust_deed.pdf',
                'insurance_document' => 'insurance/dh_policy.pdf',
                'valuation_report' => 'valuation/dh_q3_2023.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 11, // Data Centers
                'portfolio_name' => 'Cloud Infrastructure',
                'annual_report' => 'reports/ci_annual_2024.pdf',
                'trust_deed_document' => 'legal/ci_trust_deed.pdf',
                'insurance_document' => 'insurance/ci_policy.pdf',
                'valuation_report' => 'valuation/ci_q2_2023.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 12, // Self Storage
                'portfolio_name' => 'SecureSpace Facilities',
                'annual_report' => 'reports/ss_annual_2024.pdf',
                'trust_deed_document' => 'legal/ss_trust_deed.pdf',
                'insurance_document' => 'insurance/ss_policy.pdf',
                'valuation_report' => 'valuation/ss_q1_2023.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 13, // Agricultural
                'portfolio_name' => 'Farmland Investments',
                'annual_report' => 'reports/fi_annual_2024.pdf',
                'trust_deed_document' => 'legal/fi_trust_deed.pdf',
                'insurance_document' => 'insurance/fi_policy.pdf',
                'valuation_report' => 'valuation/fi_q4_2022.pdf',
                'status' => 'Draft'
            ],
            [
                'portfolio_types_id' => 14, // Leisure
                'portfolio_name' => 'Recreation Parks',
                'annual_report' => 'reports/rp_annual_2024.pdf',
                'trust_deed_document' => 'legal/rp_trust_deed.pdf',
                'insurance_document' => 'insurance/rp_policy.pdf',
                'valuation_report' => 'valuation/rp_q3_2022.pdf',
                'status' => 'Active'
            ],
            [
                'portfolio_types_id' => 15, // Student Housing
                'portfolio_name' => 'University Accommodations',
                'annual_report' => 'reports/ua_annual_2024.pdf',
                'trust_deed_document' => 'legal/ua_trust_deed.pdf',
                'insurance_document' => 'insurance/ua_policy.pdf',
                'valuation_report' => 'valuation/ua_q2_2022.pdf',
                'status' => 'Active'
            ]
        ];

        foreach ($portfolios as $portfolio) {
            DB::table('portfolios')->insert([
                'portfolio_types_id' => $portfolio['portfolio_types_id'],
                'portfolio_name' => $portfolio['portfolio_name'],
                'annual_report' => $portfolio['annual_report'],
                'trust_deed_document' => $portfolio['trust_deed_document'],
                'insurance_document' => $portfolio['insurance_document'],
                'valuation_report' => $portfolio['valuation_report'],
                'status' => $portfolio['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Properties
        $properties = [
            [
                'portfolio_id' => 1, // Skyline Residences
                'category' => 'Apartments',
                'batch_no' => 'SR-001',
                'name' => 'Skyline Tower A',
                'address' => '123 Skyview Road',
                'city' => 'Singapore',
                'state' => 'Central Region',
                'country' => 'Singapore',
                'postal_code' => '123456',
                'land_size' => 2500.00,
                'gross_floor_area' => 15000.00,
                'usage' => 'Residential',
                'value' => 25000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 25000000.00,
                'market_value' => 28000000.00,
                'status' => 'Active',
                'prepared_by' => 'John Smith',
                'verified_by' => 'Sarah Johnson',
                'remarks' => 'Luxury apartment building with 25 floors'
            ],
            [
                'portfolio_id' => 1, // Skyline Residences
                'category' => 'Apartments',
                'batch_no' => 'SR-002',
                'name' => 'Skyline Tower B',
                'address' => '125 Skyview Road',
                'city' => 'Singapore',
                'state' => 'Central Region',
                'country' => 'Singapore',
                'postal_code' => '123457',
                'land_size' => 2300.00,
                'gross_floor_area' => 14000.00,
                'usage' => 'Residential',
                'value' => 23000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 23000000.00,
                'market_value' => 25500000.00,
                'status' => 'Active',
                'prepared_by' => 'John Smith',
                'verified_by' => 'Sarah Johnson',
                'remarks' => 'Luxury apartment building with 23 floors'
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'category' => 'Office',
                'batch_no' => 'DBC-001',
                'name' => 'Central Business Tower',
                'address' => '500 Business Avenue',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '50000',
                'land_size' => 3500.00,
                'gross_floor_area' => 28000.00,
                'usage' => 'Commercial',
                'value' => 45000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 45000000.00,
                'market_value' => 48000000.00,
                'status' => 'Active',
                'prepared_by' => 'David Wong',
                'verified_by' => 'Michelle Tan',
                'remarks' => 'Prime office location in the financial district'
            ],
            [
                'portfolio_id' => 3, // Urban Complex
                'category' => 'Mixed Use',
                'batch_no' => 'UC-001',
                'name' => 'Urban Heights',
                'address' => '888 Metro Boulevard',
                'city' => 'Jakarta',
                'state' => 'Jakarta Capital Region',
                'country' => 'Indonesia',
                'postal_code' => '10110',
                'land_size' => 6500.00,
                'gross_floor_area' => 45000.00,
                'usage' => 'Mixed Use',
                'value' => 62000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 62000000.00,
                'market_value' => 68000000.00,
                'status' => 'Active',
                'prepared_by' => 'Ahmad Yusof',
                'verified_by' => 'Nadia Ibrahim',
                'remarks' => 'Combined residential and commercial complex'
            ],
            [
                'portfolio_id' => 4, // Central Shopping Mall
                'category' => 'Retail',
                'batch_no' => 'CSM-001',
                'name' => 'Central Mall Plaza',
                'address' => '100 Shopping Avenue',
                'city' => 'Bangkok',
                'state' => 'Bangkok Metropolitan',
                'country' => 'Thailand',
                'postal_code' => '10330',
                'land_size' => 8000.00,
                'gross_floor_area' => 52000.00,
                'usage' => 'Retail',
                'value' => 78000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 78000000.00,
                'market_value' => 85000000.00,
                'status' => 'Active',
                'prepared_by' => 'Somchai Patel',
                'verified_by' => 'Picha Wong',
                'remarks' => 'Major shopping mall with 300 retail units'
            ],
            [
                'portfolio_id' => 5, // Tech Industrial Park
                'category' => 'Industrial',
                'batch_no' => 'TIP-001',
                'name' => 'Tech Manufacturing Facility',
                'address' => '25 Industrial Road',
                'city' => 'Penang',
                'state' => 'Penang',
                'country' => 'Malaysia',
                'postal_code' => '11900',
                'land_size' => 12000.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Industrial',
                'value' => 32000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 32000000.00,
                'market_value' => 34000000.00,
                'status' => 'Active',
                'prepared_by' => 'Tan Wei Liang',
                'verified_by' => 'Lim Mei Ling',
                'remarks' => 'Advanced manufacturing facility for electronics'
            ],
            [
                'portfolio_id' => 6, // Executive Tower
                'category' => 'Office',
                'batch_no' => 'ET-001',
                'name' => 'Executive Plaza',
                'address' => '1 Corporate Drive',
                'city' => 'Singapore',
                'state' => 'Central Region',
                'country' => 'Singapore',
                'postal_code' => '068883',
                'land_size' => 3200.00,
                'gross_floor_area' => 35000.00,
                'usage' => 'Commercial',
                'value' => 55000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 55000000.00,
                'market_value' => 60000000.00,
                'status' => 'Active',
                'prepared_by' => 'Jennifer Koh',
                'verified_by' => 'Michael Lee',
                'remarks' => 'Grade A office building in prime CBD location'
            ],
            [
                'portfolio_id' => 7, // Luxury Resort Collection
                'category' => 'Hospitality',
                'batch_no' => 'LRC-001',
                'name' => 'Beach Resort & Spa',
                'address' => '25 Beachfront Avenue',
                'city' => 'Bali',
                'state' => 'Badung',
                'country' => 'Indonesia',
                'postal_code' => '80361',
                'land_size' => 25000.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Hospitality',
                'value' => 45000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 45000000.00,
                'market_value' => 52000000.00,
                'status' => 'Active',
                'prepared_by' => 'Putu Wijaya',
                'verified_by' => 'Made Sukma',
                'remarks' => '5-star beachfront resort with 120 rooms and villas'
            ],
            [
                'portfolio_id' => 8, // Medical Plaza
                'category' => 'Healthcare',
                'batch_no' => 'MP-001',
                'name' => 'Central Medical Center',
                'address' => '50 Health Boulevard',
                'city' => 'Manila',
                'state' => 'Metro Manila',
                'country' => 'Philippines',
                'postal_code' => '1000',
                'land_size' => 5500.00,
                'gross_floor_area' => 25000.00,
                'usage' => 'Healthcare',
                'value' => 38000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 38000000.00,
                'market_value' => 40000000.00,
                'status' => 'Active',
                'prepared_by' => 'Maria Santos',
                'verified_by' => 'Jose Cruz',
                'remarks' => 'Modern medical facility with specialized units'
            ],
            [
                'portfolio_id' => 9, // Campus Properties
                'category' => 'Educational',
                'batch_no' => 'CP-001',
                'name' => 'University Research Building',
                'address' => '15 Academia Drive',
                'city' => 'Singapore',
                'state' => 'Western Region',
                'country' => 'Singapore',
                'postal_code' => '639798',
                'land_size' => 4500.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Educational',
                'value' => 28000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 28000000.00,
                'market_value' => 30000000.00,
                'status' => 'Draft',
                'prepared_by' => 'Ravi Kumar',
                'verified_by' => null,
                'remarks' => 'Research facility leased to major university'
            ],
            [
                'portfolio_id' => 10, // Distribution Hub
                'category' => 'Logistics',
                'batch_no' => 'DH-001',
                'name' => 'Central Distribution Warehouse',
                'address' => '8 Logistics Way',
                'city' => 'Ho Chi Minh City',
                'state' => 'District 9',
                'country' => 'Vietnam',
                'postal_code' => '700000',
                'land_size' => 18000.00,
                'gross_floor_area' => 15000.00,
                'usage' => 'Logistics',
                'value' => 25000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 25000000.00,
                'market_value' => 27000000.00,
                'status' => 'Active',
                'prepared_by' => 'Nguyen Van Minh',
                'verified_by' => 'Tran Thi Hoa',
                'remarks' => 'Modern distribution center with cold storage'
            ],
            [
                'portfolio_id' => 11, // Cloud Infrastructure
                'category' => 'Data Center',
                'batch_no' => 'CI-001',
                'name' => 'Cloud Data Center',
                'address' => '10 Digital Avenue',
                'city' => 'Singapore',
                'state' => 'Eastern Region',
                'country' => 'Singapore',
                'postal_code' => '486048',
                'land_size' => 8500.00,
                'gross_floor_area' => 12000.00,
                'usage' => 'Technology',
                'value' => 65000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 65000000.00,
                'market_value' => 70000000.00,
                'status' => 'Active',
                'prepared_by' => 'Desmond Lim',
                'verified_by' => 'Rachel Teo',
                'remarks' => 'Tier 4 data center with redundant systems'
            ],
            [
                'portfolio_id' => 12, // SecureSpace Facilities
                'category' => 'Self Storage',
                'batch_no' => 'SS-001',
                'name' => 'SecureSpace Center',
                'address' => '55 Storage Road',
                'city' => 'Kuala Lumpur',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '47500',
                'land_size' => 10000.00,
                'gross_floor_area' => 8500.00,
                'usage' => 'Storage',
                'value' => 15000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 15000000.00,
                'market_value' => 16500000.00,
                'status' => 'Active',
                'prepared_by' => 'Amir Hassan',
                'verified_by' => 'Farah Ahmad',
                'remarks' => 'Climate-controlled storage facility with 500 units'
            ],
            [
                'portfolio_id' => 13, // Farmland Investments
                'category' => 'Agricultural',
                'batch_no' => 'FI-001',
                'name' => 'Palm Plantation Estate',
                'address' => 'Rural Route 25',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '81200',
                'land_size' => 500000.00,
                'gross_floor_area' => 2500.00,
                'usage' => 'Agricultural',
                'value' => 18000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 18000000.00,
                'market_value' => 20000000.00,
                'status' => 'Draft',
                'prepared_by' => 'Chong Wei Ming',
                'verified_by' => null,
                'remarks' => 'Palm oil plantation with processing facilities'
            ],
            [
                'portfolio_id' => 14, // Recreation Parks
                'category' => 'Leisure',
                'batch_no' => 'RP-001',
                'name' => 'Family Fun Park',
                'address' => '200 Recreation Boulevard',
                'city' => 'Bangkok',
                'state' => 'Pathum Thani',
                'country' => 'Thailand',
                'postal_code' => '12120',
                'land_size' => 85000.00,
                'gross_floor_area' => 12000.00,
                'usage' => 'Recreation',
                'value' => 22000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 22000000.00,
                'market_value' => 24000000.00,
                'status' => 'Active',
                'prepared_by' => 'Chai Sombat',
                'verified_by' => 'Naree Wattana',
                'remarks' => 'Theme park with water attractions and amenities'
            ],
            [
                'portfolio_id' => 15, // University Accommodations
                'category' => 'Student Housing',
                'batch_no' => 'UA-001',
                'name' => 'Campus View Residences',
                'address' => '75 University Avenue',
                'city' => 'Singapore',
                'state' => 'Western Region',
                'country' => 'Singapore',
                'postal_code' => '639789',
                'land_size' => 4000.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Residential',
                'value' => 32000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 32000000.00,
                'market_value' => 35000000.00,
                'status' => 'Active',
                'prepared_by' => 'Teo Jia Ming',
                'verified_by' => 'Linda Kwok',
                'remarks' => 'Modern student accommodation with 500 beds'
            ]
        ];
        
        foreach ($properties as $property) {
            DB::table('properties')->insert([
                'portfolio_id' => $property['portfolio_id'],
                'category' => $property['category'],
                'batch_no' => $property['batch_no'],
                'name' => $property['name'],
                'address' => $property['address'],
                'city' => $property['city'],
                'state' => $property['state'],
                'country' => $property['country'],
                'postal_code' => $property['postal_code'],
                'land_size' => $property['land_size'],
                'gross_floor_area' => $property['gross_floor_area'],
                'usage' => $property['usage'],
                'value' => $property['value'],
                'ownership' => $property['ownership'],
                'share_amount' => $property['share_amount'],
                'market_value' => $property['market_value'],
                'status' => $property['status'],
                'prepared_by' => $property['prepared_by'],
                'verified_by' => $property['verified_by'],
                'remarks' => $property['remarks'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Tenants
        $tenants = [
            [
                'property_id' => 1, // Skyline Tower A
                'name' => 'Global Finance Corp',
                'contact_person' => 'James Wilson',
                'email' => 'jwilson@globalfinance.com',
                'phone' => '+65 9123 4567',
                'commencement_date' => '2023-06-01',
                'approval_date' => '2023-05-15',
                'expiry_date' => '2028-05-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 1, // Skyline Tower A
                'name' => 'Tech Innovations Pte Ltd',
                'contact_person' => 'Sarah Chen',
                'email' => 'schen@techinnovations.com',
                'phone' => '+65 9234 5678',
                'commencement_date' => '2024-01-01',
                'approval_date' => '2023-12-10',
                'expiry_date' => '2026-12-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 2, // Skyline Tower B
                'name' => 'Legal Associates LLP',
                'contact_person' => 'Michael Brown',
                'email' => 'mbrown@legalassociates.com',
                'phone' => '+65 9345 6789',
                'commencement_date' => '2023-09-15',
                'approval_date' => '2023-08-30',
                'expiry_date' => '2026-09-14',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 3, // Central Business Tower
                'name' => 'Standard Insurance Group',
                'contact_person' => 'David Lee',
                'email' => 'dlee@standardinsurance.com',
                'phone' => '+60 12 345 6789',
                'commencement_date' => '2022-11-01',
                'approval_date' => '2022-10-15',
                'expiry_date' => '2027-10-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 3, // Central Business Tower
                'name' => 'Consulting Partners International',
                'contact_person' => 'Rachel Tan',
                'email' => 'rtan@consultingpartners.com',
                'phone' => '+60 12 456 7890',
                'commencement_date' => '2023-02-01',
                'approval_date' => '2023-01-15',
                'expiry_date' => '2028-01-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 4, // Urban Heights
                'name' => 'Skyline Retailers',
                'contact_person' => 'Ahmad Rizal',
                'email' => 'arizal@skylineretailers.com',
                'phone' => '+62 21 1234 5678',
                'commencement_date' => '2023-04-01',
                'approval_date' => '2023-03-15',
                'expiry_date' => '2028-03-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 5, // Central Mall Plaza
                'name' => 'Fashion Forward',
                'contact_person' => 'Nattapong Chai',
                'email' => 'nchai@fashionforward.com',
                'phone' => '+66 2 123 4567',
                'commencement_date' => '2023-07-01',
                'approval_date' => '2023-06-15',
                'expiry_date' => '2028-06-30',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 5, // Central Mall Plaza
                'name' => 'Global Electronics',
                'contact_person' => 'Supaporn Wattana',
                'email' => 'swattana@globalelectronics.com',
                'phone' => '+66 2 234 5678',
                'commencement_date' => '2023-08-01',
                'approval_date' => '2023-07-15',
                'expiry_date' => '2028-07-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 6, // Tech Manufacturing Facility
                'name' => 'Advanced Semiconductors Inc.',
                'contact_person' => 'Lim Eng Huat',
                'email' => 'ehuat@advancedsemi.com',
                'phone' => '+60 4 123 4567',
                'commencement_date' => '2022-05-01',
                'approval_date' => '2022-04-15',
                'expiry_date' => '2032-04-30',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 7, // Executive Plaza
                'name' => 'Global Ventures Capital',
                'contact_person' => 'Jennifer Lim',
                'email' => 'jlim@globalventures.com',
                'phone' => '+65 9456 7890',
                'commencement_date' => '2023-03-01',
                'approval_date' => '2023-02-15',
                'expiry_date' => '2028-02-29',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 7, // Executive Plaza
                'name' => 'Pacific Trading Group',
                'contact_person' => 'Kenneth Wong',
                'email' => 'kwong@pacifictrading.com',
                'phone' => '+65 9567 8901',
                'commencement_date' => '2023-05-01',
                'approval_date' => '2023-04-15',
                'expiry_date' => '2028-04-30',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 8, // Beach Resort & Spa
                'name' => 'Luxury Escapes',
                'contact_person' => 'Made Surya',
                'email' => 'msurya@luxuryescapes.com',
                'phone' => '+62 361 123 456',
                'commencement_date' => '2022-12-01',
                'approval_date' => '2022-11-15',
                'expiry_date' => '2037-11-30',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 9, // Central Medical Center
                'name' => 'Premier Healthcare Systems',
                'contact_person' => 'Elena Santos',
                'email' => 'esantos@premierhealthcare.com',
                'phone' => '+63 2 123 4567',
                'commencement_date' => '2022-10-01',
                'approval_date' => '2022-09-15',
                'expiry_date' => '2032-09-30',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 10, // University Research Building
                'name' => 'National University Research',
                'contact_person' => 'Dr. Tan Li Wei',
                'email' => 'tlwei@nationaluniv.edu',
                'phone' => '+65 9678 9012',
                'commencement_date' => '2023-01-01',
                'approval_date' => '2022-12-15',
                'expiry_date' => '2027-12-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ],
            [
                'property_id' => 11, // Central Distribution Warehouse
                'name' => 'Asia Logistics Solutions',
                'contact_person' => 'Tran Van Duc',
                'email' => 'tvduc@asialogistics.com',
                'phone' => '+84 28 1234 5678',
                'commencement_date' => '2023-02-01',
                'approval_date' => '2023-01-15',
                'expiry_date' => '2028-01-31',
                'status' => 'active',
                'approval_status' => 'approved'
            ]
        ];

        foreach ($tenants as $tenant) {
            DB::table('tenants')->insert([
                'property_id' => $tenant['property_id'],
                'name' => $tenant['name'],
                'contact_person' => $tenant['contact_person'],
                'email' => $tenant['email'],
                'phone' => $tenant['phone'],
                'commencement_date' => $tenant['commencement_date'],
                'approval_date' => $tenant['approval_date'],
                'expiry_date' => $tenant['expiry_date'],
                'status' => $tenant['status'],
                'approval_status' => $tenant['approval_status'],
                'last_approval_date' => $tenant['approval_date'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Leases
        $leases = [
            [
                'tenant_id' => 1, // Global Finance Corp
                'lease_name' => 'GFC Office Lease',
                'demised_premises' => 'Floors 20-25, Skyline Tower A',
                'permitted_use' => 'Office Space',
                'rental_amount' => 85000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-06-01',
                'end_date' => '2028-05-31',
                'status' => 'active'
            ],
            [
                'tenant_id' => 2, // Tech Innovations Pte Ltd
                'lease_name' => 'Tech Innovations Lease',
                'demised_premises' => 'Floors 15-18, Skyline Tower A',
                'permitted_use' => 'Office Space',
                'rental_amount' => 65000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '3',
                'start_date' => '2024-01-01',
                'end_date' => '2026-12-31',
                'status' => 'active'
            ],
            [
                'tenant_id' => 3, // Legal Associates LLP
                'lease_name' => 'Legal Associates Lease',
                'demised_premises' => 'Floors 10-14, Skyline Tower B',
                'permitted_use' => 'Office Space',
                'rental_amount' => 72000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '3',
                'start_date' => '2023-09-15',
                'end_date' => '2026-09-14',
                'status' => 'active'
            ],
            [
                'tenant_id' => 4, // Standard Insurance Group
                'lease_name' => 'Standard Insurance Lease',
                'demised_premises' => 'Floors 25-30, Central Business Tower',
                'permitted_use' => 'Office Space',
                'rental_amount' => 95000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2022-11-01',
                'end_date' => '2027-10-31',
                'status' => 'active'
            ],
            [
                'tenant_id' => 5, // Consulting Partners International
                'lease_name' => 'Consulting Partners Lease',
                'demised_premises' => 'Floors 15-20, Central Business Tower',
                'permitted_use' => 'Office Space',
                'rental_amount' => 82000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-02-01',
                'end_date' => '2028-01-31',
                'status' => 'active'
            ],  
            [
                'tenant_id' => 6, // Skyline Retailers
                'lease_name' => 'Skyline Retail Lease',
                'demised_premises' => 'Ground floor units 1-10, Urban Heights',
                'permitted_use' => 'Retail',
                'rental_amount' => 120000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-04-01',
                'end_date' => '2028-03-31',
                'status' => 'active'
            ],
            [
                'tenant_id' => 7, // Fashion Forward
                'lease_name' => 'Fashion Forward Anchor Lease',
                'demised_premises' => 'South Wing, Floors 1-3, Central Mall Plaza',
                'permitted_use' => 'Retail',
                'rental_amount' => 150000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-07-01',
                'end_date' => '2028-06-30',
                'status' => 'active'
            ],
            [
                'tenant_id' => 8, // Global Electronics
                'lease_name' => 'Global Electronics Retail Lease',
                'demised_premises' => 'North Wing, Floor 2, Central Mall Plaza',
                'permitted_use' => 'Retail',
                'rental_amount' => 135000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-08-01',
                'end_date' => '2028-07-31',
                'status' => 'active'
            ],
            [
                'tenant_id' => 9, // Advanced Semiconductors Inc.
                'lease_name' => 'Advanced Semiconductors Manufacturing Lease',
                'demised_premises' => 'Entire facility, Tech Manufacturing Facility',
                'permitted_use' => 'Industrial Manufacturing',
                'rental_amount' => 180000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '10',
                'start_date' => '2022-05-01',
                'end_date' => '2032-04-30',
                'status' => 'active'
            ],
            [
                'tenant_id' => 10, // Global Ventures Capital
                'lease_name' => 'Global Ventures Office Lease',
                'demised_premises' => 'Floors 15-20, Executive Plaza',
                'permitted_use' => 'Office Space',
                'rental_amount' => 110000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-03-01',
                'end_date' => '2028-02-29',
                'status' => 'active'
            ],
            [
                'tenant_id' => 11, // Pacific Trading Group
                'lease_name' => 'Pacific Trading Office Lease',
                'demised_premises' => 'Floors 10-14, Executive Plaza',
                'permitted_use' => 'Office Space',
                'rental_amount' => 95000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-05-01',
                'end_date' => '2028-04-30',
                'status' => 'active'
            ],
            [
                'tenant_id' => 12, // Luxury Escapes
                'lease_name' => 'Luxury Escapes Resort Lease',
                'demised_premises' => 'Entire property, Beach Resort & Spa',
                'permitted_use' => 'Hospitality',
                'rental_amount' => 320000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '15',
                'start_date' => '2022-12-01',
                'end_date' => '2037-11-30',
                'status' => 'active'
            ],
            [
                'tenant_id' => 13, // Premier Healthcare Systems
                'lease_name' => 'Premier Healthcare Facility Lease',
                'demised_premises' => 'Entire facility, Central Medical Center',
                'permitted_use' => 'Healthcare',
                'rental_amount' => 250000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '10',
                'start_date' => '2022-10-01',
                'end_date' => '2032-09-30',
                'status' => 'active'
            ],
            [
                'tenant_id' => 14, // National University Research
                'lease_name' => 'University Research Lease',
                'demised_premises' => 'Entire building, University Research Building',
                'permitted_use' => 'Educational & Research',
                'rental_amount' => 160000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-01-01',
                'end_date' => '2027-12-31',
                'status' => 'active'
            ],
            [
                'tenant_id' => 15, // Asia Logistics Solutions
                'lease_name' => 'Asia Logistics Warehouse Lease',
                'demised_premises' => 'Entire facility, Central Distribution Warehouse',
                'permitted_use' => 'Logistics & Distribution',
                'rental_amount' => 145000.00,
                'rental_frequency' => 'monthly',
                'option_to_renew' => true,
                'term_years' => '5',
                'start_date' => '2023-02-01',
                'end_date' => '2028-01-31',
                'status' => 'active'
            ]
        ];
        
        foreach ($leases as $lease) {
            DB::table('leases')->insert([
                'tenant_id' => $lease['tenant_id'],
                'lease_name' => $lease['lease_name'],
                'demised_premises' => $lease['demised_premises'],
                'permitted_use' => $lease['permitted_use'],
                'rental_amount' => $lease['rental_amount'],
                'rental_frequency' => $lease['rental_frequency'],
                'option_to_renew' => $lease['option_to_renew'],
                'term_years' => $lease['term_years'],
                'start_date' => $lease['start_date'],
                'end_date' => $lease['end_date'],
                'status' => $lease['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Site Visits
        $siteVisits = [
            [
                'property_id' => 1, // Skyline Tower A
                'date_visit' => '2024-01-15',
                'time_visit' => '10:00:00',
                'inspector_name' => 'John Smith',
                'notes' => 'Routine annual inspection of the property',
                'attachment' => 'visits/skyline_a_2024_01_15.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 2, // Skyline Tower B
                'date_visit' => '2024-01-16',
                'time_visit' => '14:00:00',
                'inspector_name' => 'John Smith',
                'notes' => 'Routine annual inspection of the property',
                'attachment' => 'visits/skyline_b_2024_01_16.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 3, // Central Business Tower
                'date_visit' => '2024-02-10',
                'time_visit' => '09:30:00',
                'inspector_name' => 'David Wong',
                'notes' => 'Inspection of newly renovated floors',
                'attachment' => 'visits/cbt_2024_02_10.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 4, // Urban Heights
                'date_visit' => '2024-02-20',
                'time_visit' => '11:00:00',
                'inspector_name' => 'Ahmad Rizal',
                'notes' => 'Assessment of common areas and facilities',
                'attachment' => 'visits/urban_heights_2024_02_20.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 5, // Central Mall Plaza
                'date_visit' => '2024-03-05',
                'time_visit' => '10:00:00',
                'inspector_name' => 'Nattapong Chai',
                'notes' => 'Inspection of retail spaces and food court',
                'attachment' => 'visits/mall_plaza_2024_03_05.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 6, // Tech Manufacturing Facility
                'date_visit' => '2024-03-15',
                'time_visit' => '09:00:00',
                'inspector_name' => 'Lim Eng Huat',
                'notes' => 'Safety and compliance inspection of industrial facility',
                'attachment' => 'visits/tech_facility_2024_03_15.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 7, // Executive Plaza
                'date_visit' => '2024-04-10',
                'time_visit' => '14:30:00',
                'inspector_name' => 'Kenneth Wong',
                'notes' => 'Review of building systems and tenant improvements',
                'attachment' => 'visits/exec_plaza_2024_04_10.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 8, // Beach Resort & Spa
                'date_visit' => '2024-04-20',
                'time_visit' => '11:00:00',
                'inspector_name' => 'Made Surya',
                'notes' => 'Inspection of resort facilities and guest accommodations',
                'attachment' => 'visits/beach_resort_2024_04_20.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 9, // Central Medical Center
                'date_visit' => '2024-05-05',
                'time_visit' => '10:00:00',
                'inspector_name' => 'Elena Santos',
                'notes' => 'Review of medical facility compliance and systems',
                'attachment' => 'visits/medical_center_2024_05_05.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 10, // University Research Building
                'date_visit' => '2024-05-15',
                'time_visit' => '13:00:00',
                'inspector_name' => 'Dr. Tan Li Wei',
                'notes' => 'Inspection of research facilities and laboratories',
                'attachment' => 'visits/uni_research_2024_05_15.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 11, // Central Distribution Warehouse
                'date_visit' => '2024-06-01',
                'time_visit' => '09:00:00',
                'inspector_name' => 'Tran Van Duc',
                'notes' => 'Safety inspection of warehouse operations',
                'attachment' => 'visits/warehouse_2024_06_01.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 12, // Cloud Data Center
                'date_visit' => '2024-06-15',
                'time_visit' => '10:30:00',
                'inspector_name' => 'Desmond Lim',
                'notes' => 'Inspection of data center infrastructure and cooling systems',
                'attachment' => 'visits/data_center_2024_06_15.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 13, // SecureSpace Center
                'date_visit' => '2024-07-01',
                'time_visit' => '11:00:00',
                'inspector_name' => 'Amir Hassan',
                'notes' => 'Review of storage facility security and climate control',
                'attachment' => 'visits/securespace_2024_07_01.pdf',
                'status' => 'completed'
            ],
            [
                'property_id' => 1, // Skyline Tower A
                'date_visit' => '2024-09-15',
                'time_visit' => '10:00:00',
                'inspector_name' => 'John Smith',
                'notes' => 'Follow-up inspection for maintenance issues',
                'attachment' => null,
                'status' => 'scheduled'
            ],
            [
                'property_id' => 3, // Central Business Tower
                'date_visit' => '2024-09-20',
                'time_visit' => '14:00:00',
                'inspector_name' => 'David Wong',
                'notes' => 'Tenant improvement inspection',
                'attachment' => null,
                'status' => 'scheduled'
            ]
        ];

        foreach ($siteVisits as $visit) {
            DB::table('site_visits')->insert([
                'property_id' => $visit['property_id'],
                'date_visit' => $visit['date_visit'],
                'time_visit' => $visit['time_visit'],
                'inspector_name' => $visit['inspector_name'],
                'notes' => $visit['notes'],
                'attachment' => $visit['attachment'],
                'status' => $visit['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Site Visit Logs
        $siteVisitLogs = [
            [
                'site_visit_id' => 1,
                'no' => 1,
                'visitation_date' => '2024-01-15',
                'purpose' => 'Annual facility inspection and tenant feedback collection',
                'status' => 'Completed',
                'report_submission_date' => '2024-01-20',
                'report_attachment' => 'reports/skyline_a_inspection_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'All systems in good working order. Minor maintenance issues in common areas to be addressed.'
            ],
            [
                'site_visit_id' => 2,
                'no' => 1,
                'visitation_date' => '2024-01-16',
                'purpose' => 'Annual facility inspection and tenant feedback collection',
                'status' => 'Completed',
                'report_submission_date' => '2024-01-21',
                'report_attachment' => 'reports/skyline_b_inspection_2024.pdf',
                'follow_up_required' => true,
                'remarks' => 'HVAC system requires maintenance. Elevator #2 needs service.'
            ],
            [
                'site_visit_id' => 3,
                'no' => 1,
                'visitation_date' => '2024-02-10',
                'purpose' => 'Inspection of newly renovated floors and tenant spaces',
                'status' => 'Completed',
                'report_submission_date' => '2024-02-15',
                'report_attachment' => 'reports/cbt_renovation_inspection_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'Renovations completed to specification. All systems operational.'
            ],
            [
                'site_visit_id' => 4,
                'no' => 1,
                'visitation_date' => '2024-02-20',
                'purpose' => 'Assessment of common areas and facilities',
                'status' => 'Completed',
                'report_submission_date' => '2024-02-25',
                'report_attachment' => 'reports/urban_heights_assessment_2024.pdf',
                'follow_up_required' => true,
                'remarks' => 'Security system upgrade recommended. Lobby requires refurbishment.'
            ],
            [
                'site_visit_id' => 5,
                'no' => 1,
                'visitation_date' => '2024-03-05',
                'purpose' => 'Inspection of retail spaces and food court',
                'status' => 'Completed',
                'report_submission_date' => '2024-03-10',
                'report_attachment' => 'reports/mall_plaza_retail_inspection_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'Food court renovation completed successfully. All retail spaces in good condition.'
            ],
            [
                'site_visit_id' => 6,
                'no' => 1,
                'visitation_date' => '2024-03-15',
                'purpose' => 'Safety and compliance inspection of industrial facility',
                'status' => 'Completed',
                'report_submission_date' => '2024-03-20',
                'report_attachment' => 'reports/tech_facility_safety_inspection_2024.pdf',
                'follow_up_required' => true,
                'remarks' => 'Fire suppression system requires upgrade to meet new regulations.'
            ],
            [
                'site_visit_id' => 7,
                'no' => 1,
                'visitation_date' => '2024-04-10',
                'purpose' => 'Review of building systems and tenant improvements',
                'status' => 'Completed',
                'report_submission_date' => '2024-04-15',
                'report_attachment' => 'reports/exec_plaza_systems_review_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'Building automation system functioning well. Tenant improvements align with guidelines.'
            ],
            [
                'site_visit_id' => 8,
                'no' => 1,
                'visitation_date' => '2024-04-20',
                'purpose' => 'Inspection of resort facilities and guest accommodations',
                'status' => 'Completed',
                'report_submission_date' => '2024-04-25',
                'report_attachment' => 'reports/beach_resort_facilities_inspection_2024.pdf',
                'follow_up_required' => true,
                'remarks' => 'Beach area requires erosion control measures. Pool equipment needs replacement.'
            ],
            [
                'site_visit_id' => 9,
                'no' => 1,
                'visitation_date' => '2024-05-05',
                'purpose' => 'Review of medical facility compliance and systems',
                'status' => 'Completed',
                'report_submission_date' => '2024-05-10',
                'report_attachment' => 'reports/medical_center_compliance_review_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'Facility meets all compliance requirements. Medical waste handling procedures excellent.'
            ],
            [
                'site_visit_id' => 10,
                'no' => 1,
                'visitation_date' => '2024-05-15',
                'purpose' => 'Inspection of research facilities and laboratories',
                'status' => 'Completed',
                'report_submission_date' => '2024-05-20',
                'report_attachment' => 'reports/uni_research_lab_inspection_2024.pdf',
                'follow_up_required' => true,
                'remarks' => 'Ventilation systems in chemical labs need upgrade. Safety protocols well implemented.'
            ],
            [
                'site_visit_id' => 11,
                'no' => 1,
                'visitation_date' => '2024-06-01',
                'purpose' => 'Safety inspection of warehouse operations',
                'status' => 'Completed',
                'report_submission_date' => '2024-06-06',
                'report_attachment' => 'reports/warehouse_safety_inspection_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'Loading dock equipment in excellent condition. Safety protocols followed rigorously.'
            ],
            [
                'site_visit_id' => 12,
                'no' => 1,
                'visitation_date' => '2024-06-15',
                'purpose' => 'Inspection of data center infrastructure and cooling systems',
                'status' => 'Completed',
                'report_submission_date' => '2024-06-20',
                'report_attachment' => 'reports/data_center_infrastructure_inspection_2024.pdf',
                'follow_up_required' => true,
                'remarks' => 'Backup power systems require testing. Cooling efficiency could be improved.'
            ],
            [
                'site_visit_id' => 13,
                'no' => 1,
                'visitation_date' => '2024-07-01',
                'purpose' => 'Review of storage facility security and climate control',
                'status' => 'Completed',
                'report_submission_date' => '2024-07-06',
                'report_attachment' => 'reports/securespace_security_review_2024.pdf',
                'follow_up_required' => false,
                'remarks' => 'Security systems functioning optimally. Climate control consistent across all units.'
            ],
            [
                'site_visit_id' => 14,
                'no' => 1,
                'visitation_date' => '2024-09-15',
                'purpose' => 'Follow-up inspection for maintenance issues',
                'status' => 'Scheduled',
                'report_submission_date' => null,
                'report_attachment' => null,
                'follow_up_required' => false,
                'remarks' => 'Scheduled to address previously identified maintenance issues.'
            ],
            [
                'site_visit_id' => 15,
                'no' => 1,
                'visitation_date' => '2024-09-20',
                'purpose' => 'Tenant improvement inspection',
                'status' => 'Scheduled',
                'report_submission_date' => null,
                'report_attachment' => null,
                'follow_up_required' => false,
                'remarks' => 'Scheduled to assess new tenant improvements on floors 25-30.'
            ]
        ];
        
        foreach ($siteVisitLogs as $log) {
            DB::table('site_visit_logs')->insert([
                'site_visit_id' => $log['site_visit_id'],
                'no' => $log['no'],
                'visitation_date' => $log['visitation_date'],
                'purpose' => $log['purpose'],
                'status' => $log['status'],
                'report_submission_date' => $log['report_submission_date'],
                'report_attachment' => $log['report_attachment'],
                'follow_up_required' => $log['follow_up_required'],
                'remarks' => $log['remarks'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Financials
        $financials = [
            [
                'portfolio_id' => 1, // Skyline Residences
                'bank_id' => 1, // HSBC Bank
                'financial_type_id' => 2, // Conventional Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2023-07-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.2500,
                'process_fee' => 125000.00,
                'total_facility_amount' => 25000000.00,
                'utilization_amount' => 25000000.00,
                'outstanding_amount' => 23500000.00,
                'interest_monthly' => 83125.00,
                'security_value_monthly' => 28000000.00,
                'facilities_agent' => 'Premier Real Estate Financials',
                'agent_contact' => '+65 9123 4567',
                'valuer' => 'Singapore Property Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'bank_id' => 3, // JP Morgan Chase
                'financial_type_id' => 4, // Term Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '10 years',
                'installment_date' => '2022-12-15',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.5000,
                'process_fee' => 225000.00,
                'total_facility_amount' => 45000000.00,
                'utilization_amount' => 45000000.00,
                'outstanding_amount' => 41250000.00,
                'interest_monthly' => 168750.00,
                'security_value_monthly' => 48000000.00,
                'facilities_agent' => 'KL Commercial Finance',
                'agent_contact' => '+60 12 345 6789',
                'valuer' => 'Malaysia Property Consultants',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 3, // Urban Complex
                'bank_id' => 9, // Maybank
                'financial_type_id' => 1, // Islamic Banking Financing
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2023-05-01',
                'profit_type' => 'Floating',
                'profit_rate' => 4.7500,
                'process_fee' => 310000.00,
                'total_facility_amount' => 62000000.00,
                'utilization_amount' => 62000000.00,
                'outstanding_amount' => 59500000.00,
                'interest_monthly' => 245208.33,
                'security_value_monthly' => 68000000.00,
                'facilities_agent' => 'Jakarta Investment Finance',
                'agent_contact' => '+62 21 987 6543',
                'valuer' => 'Indonesian Property Services',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 4, // Central Shopping Mall
                'bank_id' => 5, // DBS Bank
                'financial_type_id' => 6, // Syndicated Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '10 years',
                'installment_date' => '2023-08-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.0000,
                'process_fee' => 390000.00,
                'total_facility_amount' => 78000000.00,
                'utilization_amount' => 78000000.00,
                'outstanding_amount' => 76500000.00,
                'interest_monthly' => 260000.00,
                'security_value_monthly' => 85000000.00,
                'facilities_agent' => 'Bangkok Commercial Finance',
                'agent_contact' => '+66 2 345 6789',
                'valuer' => 'Thai Property Appraisers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 5, // Tech Industrial Park
                'bank_id' => 10, // CIMB Bank
                'financial_type_id' => 5, // Bridge Financing
                'purpose' => 'Facility Upgrade',
                'tenure' => '5 years',
                'installment_date' => '2023-03-15',
                'profit_type' => 'Fixed',
                'profit_rate' => 5.5000,
                'process_fee' => 160000.00,
                'total_facility_amount' => 32000000.00,
                'utilization_amount' => 32000000.00,
                'outstanding_amount' => 29500000.00,
                'interest_monthly' => 146666.67,
                'security_value_monthly' => 34000000.00,
                'facilities_agent' => 'Penang Industrial Finance',
                'agent_contact' => '+60 4 567 8901',
                'valuer' => 'MYS Industrial Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 6, // Executive Tower
                'bank_id' => 2, // Citibank
                'financial_type_id' => 2, // Conventional Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2023-04-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.2500,
                'process_fee' => 275000.00,
                'total_facility_amount' => 55000000.00,
                'utilization_amount' => 55000000.00,
                'outstanding_amount' => 53000000.00,
                'interest_monthly' => 194791.67,
                'security_value_monthly' => 60000000.00,
                'facilities_agent' => 'SG Commercial Property Finance',
                'agent_contact' => '+65 9456 7890',
                'valuer' => 'Singapore Commercial Appraisers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 7, // Luxury Resort Collection
                'bank_id' => 8, // UOB Bank
                'financial_type_id' => 4, // Term Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '20 years',
                'installment_date' => '2023-01-15',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.5000,
                'process_fee' => 225000.00,
                'total_facility_amount' => 45000000.00,
                'utilization_amount' => 45000000.00,
                'outstanding_amount' => 43500000.00,
                'interest_monthly' => 168750.00,
                'security_value_monthly' => 52000000.00,
                'facilities_agent' => 'Bali Resort Finance',
                'agent_contact' => '+62 361 234 5678',
                'valuer' => 'Indonesian Hospitality Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 8, // Medical Plaza
                'bank_id' => 7, // OCBC Bank
                'financial_type_id' => 2, // Conventional Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2022-11-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.3500,
                'process_fee' => 190000.00,
                'total_facility_amount' => 38000000.00,
                'utilization_amount' => 38000000.00,
                'outstanding_amount' => 36000000.00,
                'interest_monthly' => 137750.00,
                'security_value_monthly' => 40000000.00,
                'facilities_agent' => 'Manila Healthcare Finance',
                'agent_contact' => '+63 2 345 6789',
                'valuer' => 'Philippine Medical Property Appraisers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 9, // Campus Properties
                'bank_id' => 6, // Standard Chartered
                'financial_type_id' => 4, // Term Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '10 years',
                'installment_date' => '2023-02-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.0000,
                'process_fee' => 140000.00,
                'total_facility_amount' => 28000000.00,
                'utilization_amount' => 28000000.00,
                'outstanding_amount' => 26500000.00,
                'interest_monthly' => 93333.33,
                'security_value_monthly' => 30000000.00,
                'facilities_agent' => 'SG Educational Finance',
                'agent_contact' => '+65 9678 9012',
                'valuer' => 'Singapore Educational Property Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 10, // Distribution Hub
                'bank_id' => 11, // RHB Bank
                'financial_type_id' => 8, // Construction Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '10 years',
                'installment_date' => '2023-03-01',
                'profit_type' => 'Floating',
                'profit_rate' => 4.7500,
                'process_fee' => 125000.00,
                'total_facility_amount' => 25000000.00,
                'utilization_amount' => 25000000.00,
                'outstanding_amount' => 23750000.00,
                'interest_monthly' => 98958.33,
                'security_value_monthly' => 27000000.00,
                'facilities_agent' => 'Vietnam Logistics Finance',
                'agent_contact' => '+84 28 234 5678',
                'valuer' => 'Vietnam Industrial Property Consultants',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 11, // Cloud Infrastructure
                'bank_id' => 4, // Bank of America
                'financial_type_id' => 2, // Conventional Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2022-09-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.0000,
                'process_fee' => 325000.00,
                'total_facility_amount' => 65000000.00,
                'utilization_amount' => 65000000.00,
                'outstanding_amount' => 61500000.00,
                'interest_monthly' => 216666.67,
                'security_value_monthly' => 70000000.00,
                'facilities_agent' => 'SG Technology Finance',
                'agent_contact' => '+65 9789 0123',
                'valuer' => 'Singapore Tech Infrastructure Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 12, // SecureSpace Facilities
                'bank_id' => 13, // Public Bank
                'financial_type_id' => 2, // Conventional Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '10 years',
                'installment_date' => '2023-01-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.5000,
                'process_fee' => 75000.00,
                'total_facility_amount' => 15000000.00,
                'utilization_amount' => 15000000.00,
                'outstanding_amount' => 14250000.00,
                'interest_monthly' => 56250.00,
                'security_value_monthly' => 16500000.00,
                'facilities_agent' => 'KL Storage Finance',
                'agent_contact' => '+60 3 456 7890',
                'valuer' => 'Malaysia Storage Facility Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 13, // Farmland Investments
                'bank_id' => 12, // Bank Islam
                'financial_type_id' => 1, // Islamic Banking Financing
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2023-02-15',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.7500,
                'process_fee' => 90000.00,
                'total_facility_amount' => 18000000.00,
                'utilization_amount' => 18000000.00,
                'outstanding_amount' => 17250000.00,
                'interest_monthly' => 71250.00,
                'security_value_monthly' => 20000000.00,
                'facilities_agent' => 'Malaysia Agricultural Finance',
                'agent_contact' => '+60 7 345 6789',
                'valuer' => 'Malaysian Agricultural Land Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 14, // Recreation Parks
                'bank_id' => 14, // Hong Leong Bank
                'financial_type_id' => 4, // Term Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '10 years',
                'installment_date' => '2023-04-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.5000,
                'process_fee' => 110000.00,
                'total_facility_amount' => 22000000.00,
                'utilization_amount' => 22000000.00,
                'outstanding_amount' => 21000000.00,
                'interest_monthly' => 82500.00,
                'security_value_monthly' => 24000000.00,
                'facilities_agent' => 'Thai Leisure Properties Finance',
                'agent_contact' => '+66 2 456 7890',
                'valuer' => 'Thai Recreational Property Valuers',
                'status' => 'active'
            ],
            [
                'portfolio_id' => 15, // University Accommodations
                'bank_id' => 15, // AmBank
                'financial_type_id' => 4, // Term Loan
                'purpose' => 'Property Acquisition',
                'tenure' => '15 years',
                'installment_date' => '2023-03-01',
                'profit_type' => 'Fixed',
                'profit_rate' => 4.2500,
                'process_fee' => 160000.00,
                'total_facility_amount' => 32000000.00,
                'utilization_amount' => 32000000.00,
                'outstanding_amount' => 30500000.00,
                'interest_monthly' => 113333.33,
                'security_value_monthly' => 35000000.00,
                'facilities_agent' => 'SG Student Housing Finance',
                'agent_contact' => '+65 9890 1234',
                'valuer' => 'Singapore Educational Property Valuers',
                'status' => 'active'
            ]
        ];

        foreach ($financials as $financial) {
            DB::table('financials')->insert([
                'portfolio_id' => $financial['portfolio_id'],
                'bank_id' => $financial['bank_id'],
                'financial_type_id' => $financial['financial_type_id'],
                'purpose' => $financial['purpose'],
                'tenure' => $financial['tenure'],
                'installment_date' => $financial['installment_date'],
                'profit_type' => $financial['profit_type'],
                'profit_rate' => $financial['profit_rate'],
                'process_fee' => $financial['process_fee'],
                'total_facility_amount' => $financial['total_facility_amount'],
                'utilization_amount' => $financial['utilization_amount'],
                'outstanding_amount' => $financial['outstanding_amount'],
                'interest_monthly' => $financial['interest_monthly'],
                'security_value_monthly' => $financial['security_value_monthly'],
                'facilities_agent' => $financial['facilities_agent'],
                'agent_contact' => $financial['agent_contact'],
                'valuer' => $financial['valuer'],
                'status' => $financial['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Checklists
        $checklists = [
            [
                // General property info
                'property_title' => 'Skyline Tower A',
                'property_location' => 'Singapore',
                
                // 1.0 Legal Documentation
                'title_ref' => 'SKA-TITLE-001',
                'title_location' => 'Legal Department Safe',
                'trust_deed_ref' => 'SKA-DEED-001',
                'trust_deed_location' => 'Legal Department Safe',
                'sale_purchase_agreement' => 'SKA-SPA-001',
                'lease_agreement_ref' => 'SKA-LEASE-001',
                'lease_agreement_location' => 'Digital Archive',
                'agreement_to_lease' => 'Complete',
                'maintenance_agreement_ref' => 'SKA-MAINT-001',
                'maintenance_agreement_location' => 'Operations Office',
                'development_agreement' => 'Not Applicable',
                'other_legal_docs' => 'Insurance certificates, property tax records',
                
                // 2.0 Tenancy Agreement
                'tenant_name' => 'Global Finance Corp',
                'tenant_property' => 'Skyline Tower A, Floors 20-25',
                'tenancy_approval_date' => '2023-05-15',
                'tenancy_commencement_date' => '2023-06-01',
                'tenancy_expiry_date' => '2028-05-31',
                
                // 3.0 External Area Conditions
                'is_general_cleanliness_satisfied' => true,
                'general_cleanliness_remarks' => 'Clean and well-maintained',
                'is_fencing_gate_satisfied' => true,
                'fencing_gate_remarks' => 'Good condition, all security features operational',
                'is_external_facade_satisfied' => true,
                'external_facade_remarks' => 'Excellent condition, recently maintained',
                'is_car_park_satisfied' => true,
                'car_park_remarks' => 'Well-marked, good condition',
                'is_land_settlement_satisfied' => true,
                'land_settlement_remarks' => 'No signs of settlement issues',
                'is_rooftop_satisfied' => true,
                'rooftop_remarks' => 'Good condition, no leaks',
                'is_drainage_satisfied' => true,
                'drainage_remarks' => 'Drainage system working effectively',
                'external_remarks' => 'All external areas well-maintained',
                
                // 4.0 Internal Area Conditions
                'is_door_window_satisfied' => true,
                'door_window_remarks' => 'All in proper working condition',
                'is_staircase_satisfied' => true,
                'staircase_remarks' => 'Well-maintained and safe',
                'is_toilet_satisfied' => true,
                'toilet_remarks' => 'Clean and in good working order',
                'is_ceiling_satisfied' => true,
                'ceiling_remarks' => 'No visible damage or issues',
                'is_wall_satisfied' => true,
                'wall_remarks' => 'Good condition throughout',
                'is_water_seeping_satisfied' => true,
                'water_seeping_remarks' => 'No signs of water damage',
                'is_loading_bay_satisfied' => true,
                'loading_bay_remarks' => 'Operational and well-maintained',
                'is_basement_car_park_satisfied' => true,
                'basement_car_park_remarks' => 'Clean, well-lit, and properly maintained',
                'internal_remarks' => 'Interior in excellent condition',
                
                // 5.0 Property Development
                'development_date' => '2022-01-15',
                'development_expansion_status' => 'No current plans',
                'development_status' => 'n/a',
                'renovation_date' => '2022-06-20',
                'renovation_status' => 'Complete',
                'renovation_completion_status' => 'completed',
                'repainting_date' => '2022-07-10',
                'external_repainting_status' => 'Scheduled for 2025',
                'repainting_completion_status' => 'pending',
                
                // 5.4 Disposal/Installation/Replacement
                'water_tank_date' => '2022-05-15',
                'water_tank_status' => 'Satisfactory',
                'water_tank_completion_status' => 'completed',
                'air_conditioning_approval_date' => '2022-08-15',
                'air_conditioning_scope' => 'Central HVAC system for entire building',
                'air_conditioning_status' => 'Operational',
                'air_conditioning_completion_status' => 'completed',
                'lift_date' => '2022-09-01',
                'lift_escalator_scope' => 'All lifts and escalators',
                'lift_escalator_status' => 'Well-maintained',
                'lift_escalator_completion_status' => 'completed',
                'fire_system_date' => '2022-07-15',
                'fire_system_scope' => 'All fire detection and suppression systems',
                'fire_system_status' => 'Up to code',
                'fire_system_completion_status' => 'completed',
                'other_system_date' => '2022-10-01',
                'other_property' => 'Backup generator, water recycling system',
                'other_completion_status' => 'completed',
                
                // 5.5 Other Proposals/Approvals
                'other_proposals_approvals' => 'Solar panel installation proposed for 2026',

                // System information
                'site_visit_id' => 1,
                'status' => 'Approved',
                'prepared_by' => 'John Smith',
                'verified_by' => 'Sarah Johnson',
                'remarks' => 'Annual inspection complete with satisfactory results',
                'approval_datetime' => '2024-01-25 14:30:00'
            ],
            // Additional checklists would follow the same pattern with their respective data
        ];

        foreach ($checklists as $checklist) {
            DB::table('checklists')->insert([
                // General property info
                'property_title' => $checklist['property_title'],
                'property_location' => $checklist['property_location'],
                
                // 1.0 Legal Documentation
                'title_ref' => $checklist['title_ref'],
                'title_location' => $checklist['title_location'],
                'trust_deed_ref' => $checklist['trust_deed_ref'],
                'trust_deed_location' => $checklist['trust_deed_location'],
                'sale_purchase_agreement' => $checklist['sale_purchase_agreement'],
                'lease_agreement_ref' => $checklist['lease_agreement_ref'],
                'lease_agreement_location' => $checklist['lease_agreement_location'],
                'agreement_to_lease' => $checklist['agreement_to_lease'],
                'maintenance_agreement_ref' => $checklist['maintenance_agreement_ref'],
                'maintenance_agreement_location' => $checklist['maintenance_agreement_location'],
                'development_agreement' => $checklist['development_agreement'],
                'other_legal_docs' => $checklist['other_legal_docs'],
                
                // 2.0 Tenancy Agreement
                'tenant_name' => $checklist['tenant_name'],
                'tenant_property' => $checklist['tenant_property'],
                'tenancy_approval_date' => $checklist['tenancy_approval_date'],
                'tenancy_commencement_date' => $checklist['tenancy_commencement_date'],
                'tenancy_expiry_date' => $checklist['tenancy_expiry_date'],
                
                // 3.0 External Area Conditions
                'is_general_cleanliness_satisfied' => $checklist['is_general_cleanliness_satisfied'],
                'general_cleanliness_remarks' => $checklist['general_cleanliness_remarks'],
                'is_fencing_gate_satisfied' => $checklist['is_fencing_gate_satisfied'],
                'fencing_gate_remarks' => $checklist['fencing_gate_remarks'],
                'is_external_facade_satisfied' => $checklist['is_external_facade_satisfied'],
                'external_facade_remarks' => $checklist['external_facade_remarks'],
                'is_car_park_satisfied' => $checklist['is_car_park_satisfied'],
                'car_park_remarks' => $checklist['car_park_remarks'],
                'is_land_settlement_satisfied' => $checklist['is_land_settlement_satisfied'],
                'land_settlement_remarks' => $checklist['land_settlement_remarks'],
                'is_rooftop_satisfied' => $checklist['is_rooftop_satisfied'],
                'rooftop_remarks' => $checklist['rooftop_remarks'],
                'is_drainage_satisfied' => $checklist['is_drainage_satisfied'],
                'drainage_remarks' => $checklist['drainage_remarks'],
                'external_remarks' => $checklist['external_remarks'],
                
                // 4.0 Internal Area Conditions
                'is_door_window_satisfied' => $checklist['is_door_window_satisfied'],
                'door_window_remarks' => $checklist['door_window_remarks'],
                'is_staircase_satisfied' => $checklist['is_staircase_satisfied'],
                'staircase_remarks' => $checklist['staircase_remarks'],
                'is_toilet_satisfied' => $checklist['is_toilet_satisfied'],
                'toilet_remarks' => $checklist['toilet_remarks'],
                'is_ceiling_satisfied' => $checklist['is_ceiling_satisfied'],
                'ceiling_remarks' => $checklist['ceiling_remarks'],
                'is_wall_satisfied' => $checklist['is_wall_satisfied'],
                'wall_remarks' => $checklist['wall_remarks'],
                'is_water_seeping_satisfied' => $checklist['is_water_seeping_satisfied'],
                'water_seeping_remarks' => $checklist['water_seeping_remarks'],
                'is_loading_bay_satisfied' => $checklist['is_loading_bay_satisfied'],
                'loading_bay_remarks' => $checklist['loading_bay_remarks'],
                'is_basement_car_park_satisfied' => $checklist['is_basement_car_park_satisfied'],
                'basement_car_park_remarks' => $checklist['basement_car_park_remarks'],
                'internal_remarks' => $checklist['internal_remarks'],
                
                // 5.0 Property Development
                'development_date' => $checklist['development_date'],
                'development_expansion_status' => $checklist['development_expansion_status'],
                'development_status' => $checklist['development_status'],
                'renovation_date' => $checklist['renovation_date'],
                'renovation_status' => $checklist['renovation_status'],
                'renovation_completion_status' => $checklist['renovation_completion_status'],
                'repainting_date' => $checklist['repainting_date'],
                'external_repainting_status' => $checklist['external_repainting_status'],
                'repainting_completion_status' => $checklist['repainting_completion_status'],
                
                // 5.4 Disposal/Installation/Replacement
                'water_tank_date' => $checklist['water_tank_date'],
                'water_tank_status' => $checklist['water_tank_status'],
                'water_tank_completion_status' => $checklist['water_tank_completion_status'],
                'air_conditioning_approval_date' => $checklist['air_conditioning_approval_date'],
                'air_conditioning_scope' => $checklist['air_conditioning_scope'],
                'air_conditioning_status' => $checklist['air_conditioning_status'],
                'air_conditioning_completion_status' => $checklist['air_conditioning_completion_status'],
                'lift_date' => $checklist['lift_date'],
                'lift_escalator_scope' => $checklist['lift_escalator_scope'],
                'lift_escalator_status' => $checklist['lift_escalator_status'],
                'lift_escalator_completion_status' => $checklist['lift_escalator_completion_status'],
                'fire_system_date' => $checklist['fire_system_date'],
                'fire_system_scope' => $checklist['fire_system_scope'],
                'fire_system_status' => $checklist['fire_system_status'],
                'fire_system_completion_status' => $checklist['fire_system_completion_status'],
                'other_system_date' => $checklist['other_system_date'],
                'other_property' => $checklist['other_property'],
                'other_completion_status' => $checklist['other_completion_status'],
                'other_proposals_approvals' => $checklist['other_proposals_approvals'],
                
                // System information
                'site_visit_id' => $checklist['site_visit_id'],
                'status' => $checklist['status'],
                'prepared_by' => $checklist['prepared_by'],
                'verified_by' => $checklist['verified_by'],
                'remarks' => $checklist['remarks'],
                'approval_datetime' => $checklist['approval_datetime'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}