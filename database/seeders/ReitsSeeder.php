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
        // Define possible statuses
        $statuses = [
            'pending', 
            'active', 
            'inactive', 
            'rejected', 
            'draft', 
            'withdrawn', 
            'completed', 
            'scheduled', 
            'cancelled',
            'in progress',
            'on hold',
            'reviewing',
            'approved',
            'expired'
        ];

        // Define colors for each status
        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-gray-100 text-gray-800',
            'rejected' => 'bg-red-100 text-red-800',
            'draft' => 'bg-blue-100 text-blue-800',
            'withdrawn' => 'bg-purple-100 text-purple-800',
            'completed' => 'bg-green-100 text-green-800',
            'scheduled' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-red-100 text-red-800',
            'in progress' => 'bg-indigo-100 text-indigo-800',
            'on hold' => 'bg-orange-100 text-orange-800',
            'reviewing' => 'bg-teal-100 text-teal-800',
            'approved' => 'bg-emerald-100 text-emerald-800',
            'expired' => 'bg-rose-100 text-rose-800'
        ];

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
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'approval_datetime' => now(),
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
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'approval_datetime' => now(),
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
            ['name' => 'Student Housing', 'description' => 'Purpose-built student accommodations'],
            ['name' => 'Real Estate', 'description' => 'Properties including residential, commercial, and industrial buildings.'],
            ['name' => 'Healthcare Facilities', 'description' => 'Hospitals, clinics, and wellness centers under management.'],
            ['name' => 'Retail Spaces', 'description' => 'Shopping malls and retail properties leased to tenants.'],
            ['name' => 'Office Buildings', 'description' => 'Corporate office spaces and business hubs.'],
        ];

        foreach ($portfolioTypes as $type) {
            DB::table('portfolio_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'approval_datetime' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Portfolios - MODIFIED: Adding all 15 portfolios here
        $portfolios = [
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AL AQAR',
                'annual_report' => 'annual_reports/al_aqar_2024.pdf',
                'trust_deed_document' => 'trust_deeds/al_aqar_trust.pdf',
                'insurance_document' => 'insurance/al_aqar_insurance.pdf',
                'valuation_report' => 'valuations/al_aqar_valuation.pdf',
            ],
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AL SALAM',
                'annual_report' => 'annual_reports/al_salam_2024.pdf',
                'trust_deed_document' => 'trust_deeds/al_salam_trust.pdf',
                'insurance_document' => 'insurance/al_salam_insurance.pdf',
                'valuation_report' => 'valuations/al_salam_valuation.pdf',
            ],
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AMANAH HARTA TANAH PNB (AHP)',
                'annual_report' => 'annual_reports/amanah_harta_tanah_pnb_2024.pdf',
                'trust_deed_document' => 'trust_deeds/amanah_harta_tanah_pnb_trust.pdf',
                'insurance_document' => 'insurance/amanah_harta_tanah_pnb_insurance.pdf',
                'valuation_report' => 'valuations/amanah_harta_tanah_pnb_valuation.pdf',
            ],
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AMANAH HARTANAH BUMIPUTERA (AHB)',
                'annual_report' => 'annual_reports/amanah_hartanah_bumiputera_2024.pdf',
                'trust_deed_document' => 'trust_deeds/amanah_hartanah_bumiputera_trust.pdf',
                'insurance_document' => 'insurance/amanah_hartanah_bumiputera_insurance.pdf',
                'valuation_report' => 'valuations/amanah_hartanah_bumiputera_valuation.pdf',
            ],
        ];

        foreach ($portfolios as $portfolio) {
            DB::table('portfolios')->insert([
                'portfolio_types_id' => $portfolio['portfolio_types_id'],
                'portfolio_name' => $portfolio['portfolio_name'],
                'annual_report' => $portfolio['annual_report'],
                'trust_deed_document' => $portfolio['trust_deed_document'],
                'insurance_document' => $portfolio['insurance_document'],
                'valuation_report' => $portfolio['valuation_report'],
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'approval_datetime' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Properties
        $properties = [
            // Portfolio ID 1 (Al Aqar)
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-001',
                'name' => 'KUANTAN WELLNESS CENTRE',
                'address' => '123 Wellness Avenue',
                'city' => 'Kuantan',
                'state' => 'Pahang',
                'country' => 'Malaysia',
                'postal_code' => '25000',
                'land_size' => 3000.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Healthcare',
                'value' => 20000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 20000000.00,
                'market_value' => 22000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Modern wellness facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-002',
                'name' => 'KPJ KAJANG SPECIALIST HOSPITAL',
                'address' => '456 Medical Drive',
                'city' => 'Kajang',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '43000',
                'land_size' => 5000.00,
                'gross_floor_area' => 25000.00,
                'usage' => 'Healthcare',
                'value' => 35000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 35000000.00,
                'market_value' => 38000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Specialist hospital facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-003',
                'name' => 'KPJ SELANGOR SPECIALIST HOSPITAL',
                'address' => '789 Healthcare Boulevard',
                'city' => 'Shah Alam',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '40000',
                'land_size' => 6000.00,
                'gross_floor_area' => 30000.00,
                'usage' => 'Healthcare',
                'value' => 40000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 40000000.00,
                'market_value' => 43000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Comprehensive specialist hospital'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-004',
                'name' => 'KPJ PERDANA SPECIALIST HOSPITAL',
                'address' => '101 Medical Center Road',
                'city' => 'Kota Bharu',
                'state' => 'Kelantan',
                'country' => 'Malaysia',
                'postal_code' => '15000',
                'land_size' => 4500.00,
                'gross_floor_area' => 20000.00,
                'usage' => 'Healthcare',
                'value' => 30000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 30000000.00,
                'market_value' => 32000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Specialized medical facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-005',
                'name' => 'DAMAI WELLNESS CENTRE',
                'address' => '250 Damai Street',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '50400',
                'land_size' => 2800.00,
                'gross_floor_area' => 15000.00,
                'usage' => 'Healthcare',
                'value' => 25000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 25000000.00,
                'market_value' => 27000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Wellness and rehabilitation center'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-006',
                'name' => 'KPJ PENANG SPECIALIST HOSPITAL',
                'address' => '570 Medical Complex',
                'city' => 'Georgetown',
                'state' => 'Penang',
                'country' => 'Malaysia',
                'postal_code' => '10450',
                'land_size' => 5500.00,
                'gross_floor_area' => 28000.00,
                'usage' => 'Healthcare',
                'value' => 38000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 38000000.00,
                'market_value' => 42000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Advanced specialty hospital'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-007',
                'name' => 'KPJ DAMANSARA SPECIALIST HOSPITAL',
                'address' => '119 Damansara Heights',
                'city' => 'Petaling Jaya',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '50490',
                'land_size' => 7000.00,
                'gross_floor_area' => 35000.00,
                'usage' => 'Healthcare',
                'value' => 45000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 45000000.00,
                'market_value' => 48000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Premium specialist hospital'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-008',
                'name' => 'KPJ AMPANG PUTERI SPECIALIST HOSPITAL',
                'address' => '1 Jalan Ampang',
                'city' => 'Ampang',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '68000',
                'land_size' => 6500.00,
                'gross_floor_area' => 32000.00,
                'usage' => 'Healthcare',
                'value' => 42000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 42000000.00,
                'market_value' => 45000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Comprehensive medical center'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-009',
                'name' => 'KPJ PUTERI SPECIALIST HOSPITAL',
                'address' => '33 Jalan Puteri',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80100',
                'land_size' => 5200.00,
                'gross_floor_area' => 26000.00,
                'usage' => 'Healthcare',
                'value' => 36000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 36000000.00,
                'market_value' => 39000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Modern healthcare facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-010',
                'name' => 'KPJ IPOH SPECIALIST HOSPITAL',
                'address' => '26 Jalan Raja',
                'city' => 'Ipoh',
                'state' => 'Perak',
                'country' => 'Malaysia',
                'postal_code' => '30450',
                'land_size' => 5800.00,
                'gross_floor_area' => 29000.00,
                'usage' => 'Healthcare',
                'value' => 38000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 38000000.00,
                'market_value' => 41000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Full-service specialist hospital'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-011',
                'name' => 'KPJ KLANG SPECIALIST HOSPITAL',
                'address' => '300 Jalan Klang',
                'city' => 'Klang',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '41200',
                'land_size' => 5000.00,
                'gross_floor_area' => 25000.00,
                'usage' => 'Healthcare',
                'value' => 34000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 34000000.00,
                'market_value' => 37000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Specialist medical facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-012',
                'name' => 'KPJ JOHOR SPECIALIST HOSPITAL',
                'address' => '39 Jalan Tebrau',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80100',
                'land_size' => 6200.00,
                'gross_floor_area' => 31000.00,
                'usage' => 'Healthcare',
                'value' => 40000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 40000000.00,
                'market_value' => 43000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Advanced medical center'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Education',
                'batch_no' => 'AQ-013',
                'name' => 'KPJ INTERNATIONAL COLLEGE BUKIT MERTAJAM',
                'address' => '100 College Road',
                'city' => 'Bukit Mertajam',
                'state' => 'Penang',
                'country' => 'Malaysia',
                'postal_code' => '14000',
                'land_size' => 12000.00,
                'gross_floor_area' => 40000.00,
                'usage' => 'Education',
                'value' => 50000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 50000000.00,
                'market_value' => 53000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Medical education facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-014',
                'name' => 'TAIPING MEDICAL CENTRE',
                'address' => '5 Medical Park',
                'city' => 'Taiping',
                'state' => 'Perak',
                'country' => 'Malaysia',
                'postal_code' => '34000',
                'land_size' => 4000.00,
                'gross_floor_area' => 18000.00,
                'usage' => 'Healthcare',
                'value' => 28000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 28000000.00,
                'market_value' => 30000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Regional medical center'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Education',
                'batch_no' => 'AQ-015',
                'name' => 'KPJH INTERNATIONAL COLLEGE NILAI',
                'address' => '25 Education Park',
                'city' => 'Nilai',
                'state' => 'Negeri Sembilan',
                'country' => 'Malaysia',
                'postal_code' => '71800',
                'land_size' => 15000.00,
                'gross_floor_area' => 45000.00,
                'usage' => 'Education',
                'value' => 55000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 55000000.00,
                'market_value' => 58000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Healthcare education campus'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-016',
                'name' => 'PROJECT OTTO',
                'address' => '88 Development Zone',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '50250',
                'land_size' => 8000.00,
                'gross_floor_area' => 35000.00,
                'usage' => 'Healthcare',
                'value' => 60000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 60000000.00,
                'market_value' => 65000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'New healthcare development project'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-017',
                'name' => 'KEDAH MEDICAL CENTRE',
                'address' => '15 Medical Avenue',
                'city' => 'Alor Setar',
                'state' => 'Kedah',
                'country' => 'Malaysia',
                'postal_code' => '05100',
                'land_size' => 5500.00,
                'gross_floor_area' => 27000.00,
                'usage' => 'Healthcare',
                'value' => 32000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 32000000.00,
                'market_value' => 34000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Regional medical facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-018',
                'name' => 'KPJ PASIR GUDANG SH',
                'address' => '55 Jalan Industri',
                'city' => 'Pasir Gudang',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '81700',
                'land_size' => 4800.00,
                'gross_floor_area' => 22000.00,
                'usage' => 'Healthcare',
                'value' => 30000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 30000000.00,
                'market_value' => 32000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Specialist hospital facility'
            ],
            [
                'portfolio_id' => 1,
                'category' => 'Healthcare',
                'batch_no' => 'AQ-019',
                'name' => 'KPJ Tawakkal Sh & KPJ Damansara SH',
                'address' => '9 Tawakkal Street',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '50300',
                'land_size' => 12500.00,
                'gross_floor_area' => 60000.00,
                'usage' => 'Healthcare',
                'value' => 85000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 85000000.00,
                'market_value' => 90000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Combined specialist hospital facilities'
            ],
            
            // Portfolio ID 2 (Al Salam)
            [
                'portfolio_id' => 2,
                'category' => 'Food & Beverage',
                'batch_no' => 'AS-001',
                'name' => 'KFC AYER HITAM',
                'address' => '123 Ayer Hitam Street',
                'city' => 'Ayer Hitam',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '86100',
                'land_size' => 800.00,
                'gross_floor_area' => 1200.00,
                'usage' => 'Commercial',
                'value' => 3000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 3000000.00,
                'market_value' => 3200000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Fast food restaurant'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Retail',
                'batch_no' => 'AS-002',
                'name' => 'KOMTAR JBCC',
                'address' => '80 Jalan Wong Ah Fook',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80000',
                'land_size' => 15000.00,
                'gross_floor_area' => 75000.00,
                'usage' => 'Commercial',
                'value' => 150000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 150000000.00,
                'market_value' => 165000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Shopping mall and commercial complex'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Food & Beverage',
                'batch_no' => 'AS-003',
                'name' => 'QSR PROPERTIES',
                'address' => '500 QSR Avenue',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '50400',
                'land_size' => 5000.00,
                'gross_floor_area' => 15000.00,
                'usage' => 'Commercial',
                'value' => 25000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 25000000.00,
                'market_value' => 28000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Quick service restaurant properties'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Retail',
                'batch_no' => 'AS-004',
                'name' => 'MART KEMPAS',
                'address' => '25 Jalan Kempas',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '81200',
                'land_size' => 10000.00,
                'gross_floor_area' => 35000.00,
                'usage' => 'Commercial',
                'value' => 40000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 40000000.00,
                'market_value' => 42000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Shopping mart and retail complex'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Industrial',
                'batch_no' => 'AS-005',
                'name' => 'CENTRE WAREHOUSE',
                'address' => '100 Industrial Zone',
                'city' => 'Shah Alam',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '40100',
                'land_size' => 15000.00,
                'gross_floor_area' => 25000.00,
                'usage' => 'Industrial',
                'value' => 22000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 22000000.00,
                'market_value' => 24000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Central distribution warehouse'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Food & Beverage',
                'batch_no' => 'AS-006',
                'name' => 'KFC DT WANGSA MAJU',
                'address' => '45 Wangsa Maju Boulevard',
                'city' => 'Kuala Lumpur',
                'state' => 'Federal Territory',
                'country' => 'Malaysia',
                'postal_code' => '53300',
                'land_size' => 1000.00,
                'gross_floor_area' => 1500.00,
                'usage' => 'Commercial',
                'value' => 4500000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 4500000.00,
                'market_value' => 4800000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Fast food restaurant with drive-through'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Office',
                'batch_no' => 'AS-007',
                'name' => 'CTOS DATA SYSTEMS SDN BHD',
                'address' => '200 Technology Park',
                'city' => 'Petaling Jaya',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '46000',
                'land_size' => 5000.00,
                'gross_floor_area' => 20000.00,
                'usage' => 'Office',
                'value' => 35000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 35000000.00,
                'market_value' => 37000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Office building for data systems company'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Education',
                'batch_no' => 'AS-008',
                'name' => 'KPJ INTERNATIONAL COLLEGE (MCMH)',
                'address' => '75 Education Drive',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80200',
                'land_size' => 12000.00,
                'gross_floor_area' => 35000.00,
                'usage' => 'Education',
                'value' => 45000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 45000000.00,
                'market_value' => 47000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Medical college campus'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Food & Beverage',
                'batch_no' => 'AS-009',
                'name' => 'PHD ULU TIRAM',
                'address' => '18 Ulu Tiram Street',
                'city' => 'Ulu Tiram',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '81800',
                'land_size' => 900.00,
                'gross_floor_area' => 1300.00,
                'usage' => 'Commercial',
                'value' => 2800000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 2800000.00,
                'market_value' => 3000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Pizza restaurant outlet'
            ],
            [
                'portfolio_id' => 2,
                'category' => 'Mixed Use',
                'batch_no' => 'AS-010',
                'name' => 'KOMTAR JBCC & MCHM',
                'address' => '85 Jalan Wong Ah Fook',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80000',
                'land_size' => 20000.00,
                'gross_floor_area' => 100000.00,
                'usage' => 'Mixed',
                'value' => 180000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 180000000.00,
                'market_value' => 195000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Shopping mall and medical center complex'
            ],
            
            // Portfolio ID 3 (AMANAH HARTA TANAH PNB (AHP))
            [
                'portfolio_id' => 3,
                'category' => 'Commercial',
                'batch_no' => 'AHP-001',
                'name' => 'CX1, CYBERJAYA',
                'address' => '1 Tech Boulevard',
                'city' => 'Cyberjaya',
                'state' => 'Selangor',
                'country' => 'Malaysia',
                'postal_code' => '63000',
                'land_size' => 10000.00,
                'gross_floor_area' => 45000.00,
                'usage' => 'Office',
                'value' => 80000000.00,
                'ownership' => 'Freehold',
                'share_amount' => 80000000.00,
                'market_value' => 85000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Premium office building'
            ],
            [
                'portfolio_id' => 3,
                'category' => 'Retail',
                'batch_no' => 'AHP-002',
                'name' => 'MYDIN HYPERMARKET, SEREMBAN 2',
                'address' => '25 Seremban 2 Avenue',
                'city' => 'Seremban',
                'state' => 'Negeri Sembilan',
                'country' => 'Malaysia',
                'postal_code' => '70300',
                'land_size' => 25000.00,
                'gross_floor_area' => 60000.00,
                'usage' => 'Retail',
                'value' => 90000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 90000000.00,
                'market_value' => 95000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Large hypermarket complex'
            ],
            
            // Portfolio ID 4 (AMANAH HARTANAH BUMIPUTERA (AHB))
            [
                'portfolio_id' => 4,
                'category' => 'Government',
                'batch_no' => 'AHB-001',
                'name' => 'PENTADBIR TANAH JOHOR BAHRU',
                'address' => '10 Land Office Road',
                'city' => 'Johor Bahru',
                'state' => 'Johor',
                'country' => 'Malaysia',
                'postal_code' => '80000',
                'land_size' => 2500.00,
                'gross_floor_area' => 8000.00,
                'usage' => 'Government Office',
                'value' => 15000000.00,
                'ownership' => 'Leasehold',
                'share_amount' => 15000000.00,
                'market_value' => 16000000.00,
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'remarks' => 'Land administration office'
            ],
        ];

        // Database insertion code
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
                'prepared_by' => $property['prepared_by'],
                'verified_by' => $property['verified_by'],
                'remarks' => $property['remarks'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Tenants
        // Find property IDs by name
        $komtarJbcc = DB::table('properties')->where('name', 'KOMTAR JBCC')->first();
        $martKempas = DB::table('properties')->where('name', 'MART KEMPAS')->first();

        // Define tenant data
        $tenants = [
            // KOMTAR JBCC tenants
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'JOHOR CORPORATION',
                'contact_person' => 'Ahmad Razif',
                'email' => 'ahmad@johorcorp.com.my',
                'phone' => '+60 12 345 6789',
                'commencement_date' => '2021-01-01',
                'approval_date' => '2020-12-15',
                'expiry_date' => '2026-12-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Al Bagus Food and Beverage Sdn Bhd',
                'contact_person' => 'Mohd Faisal',
                'email' => 'faisal@albagus.com.my',
                'phone' => '+60 13 456 7890',
                'commencement_date' => '2020-10-01',
                'approval_date' => '2020-09-15',
                'expiry_date' => '2025-09-30', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'BNX Delight Sdn Bhd',
                'contact_person' => 'Lim Wei Ling',
                'email' => 'weiling@bnxdelight.com',
                'phone' => '+60 14 567 8901',
                'commencement_date' => '2022-03-15',
                'approval_date' => '2022-02-28',
                'expiry_date' => '2025-03-14', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'BNX Takahara Sdn Bhd',
                'contact_person' => 'Takahara Kenji',
                'email' => 'kenji@bnxtakahara.com',
                'phone' => '+60 15 678 9012',
                'commencement_date' => '2021-05-01',
                'approval_date' => '2021-04-15',
                'expiry_date' => '2026-04-30', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Caring Pharmacy Retail Management Sdn Bhd',
                'contact_person' => 'Sarah Lee',
                'email' => 'sarahlee@caringpharmacy.com',
                'phone' => '+60 16 789 0123',
                'commencement_date' => '2019-11-01',
                'approval_date' => '2019-10-15',
                'expiry_date' => '2024-10-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Chamelon Sdn Bhd',
                'contact_person' => 'Tan Mei Hua',
                'email' => 'meihua@chamelon.com.my',
                'phone' => '+60 17 890 1234',
                'commencement_date' => '2022-01-15',
                'approval_date' => '2021-12-30',
                'expiry_date' => '2027-01-14', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Chrisna Jenio Sdn Bhd',
                'contact_person' => 'Christina Wong',
                'email' => 'christina@chrisnajenio.com',
                'phone' => '+60 18 901 2345',
                'commencement_date' => '2020-07-01',
                'approval_date' => '2020-06-15',
                'expiry_date' => '2025-06-30', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Era Sag (JB) Sdn Bhd',
                'contact_person' => 'Amirul Rashid',
                'email' => 'amirul@erasag.com.my',
                'phone' => '+60 19 012 3456',
                'commencement_date' => '2021-09-01',
                'approval_date' => '2021-08-15',
                'expiry_date' => '2026-08-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Eyeflex Optometrix Sdn Bhd',
                'contact_person' => 'Dr. Wong Kai Yee',
                'email' => 'drwong@eyeflex.com.my',
                'phone' => '+60 12 123 4567',
                'commencement_date' => '2022-02-15',
                'approval_date' => '2022-01-30',
                'expiry_date' => '2025-02-14', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'F.O.S Apparel Group Sdn Bhd',
                'contact_person' => 'Tony Lim',
                'email' => 'tony@fosapparel.com',
                'phone' => '+60 13 234 5678',
                'commencement_date' => '2019-04-01',
                'approval_date' => '2019-03-15',
                'expiry_date' => '2024-03-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Grand Companies Sdn Bhd',
                'contact_person' => 'Lee Chong Wei',
                'email' => 'chongwei@grandcompanies.com',
                'phone' => '+60 14 345 6789',
                'commencement_date' => '2020-05-01',
                'approval_date' => '2020-04-15',
                'expiry_date' => '2025-04-30', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'KPK Quantity Surveyors (Semenanjung) Sdn Bhd',
                'contact_person' => 'Dato\' Seri Khairul',
                'email' => 'khairul@kpkqs.com.my',
                'phone' => '+60 15 456 7890',
                'commencement_date' => '2021-03-01',
                'approval_date' => '2021-02-15',
                'expiry_date' => '2026-02-28', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Habib Jewels Franchise Sdn Bhd',
                'contact_person' => 'Habib Rahman',
                'email' => 'habib@habibjewels.com.my',
                'phone' => '+60 16 567 8901',
                'commencement_date' => '2019-06-01',
                'approval_date' => '2019-05-15',
                'expiry_date' => '2024-05-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'JPS Fashions (Malaysia) Sdn Bhd',
                'contact_person' => 'Jessica Phua',
                'email' => 'jessica@jpsfashions.com',
                'phone' => '+60 17 678 9012',
                'commencement_date' => '2022-04-01',
                'approval_date' => '2022-03-15',
                'expiry_date' => '2027-03-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'La Mior Sdn Bhd',
                'contact_person' => 'Mior Ahmad',
                'email' => 'mior@lamior.com.my',
                'phone' => '+60 18 789 0123',
                'commencement_date' => '2020-09-01',
                'approval_date' => '2020-08-15',
                'expiry_date' => '2025-08-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'LAC Global Brands (Malaysia) Sdn Bhd',
                'contact_person' => 'Wendy Chong',
                'email' => 'wendy@lacglobal.com.my',
                'phone' => '+60 19 890 1234',
                'commencement_date' => '2021-11-01',
                'approval_date' => '2021-10-15',
                'expiry_date' => '2026-10-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Luxe Hair Group Sdn Bhd',
                'contact_person' => 'Aishah Mahmood',
                'email' => 'aishah@luxehair.com.my',
                'phone' => '+60 12 901 2345',
                'commencement_date' => '2022-05-15',
                'approval_date' => '2022-04-30',
                'expiry_date' => '2027-05-14', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Johor Plantations Group Berhad',
                'contact_person' => 'Tan Sri Ibrahim',
                'email' => 'ibrahim@johorplantations.com.my',
                'phone' => '+60 13 012 3456',
                'commencement_date' => '2019-02-01',
                'approval_date' => '2019-01-15',
                'expiry_date' => '2024-01-31', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Yayasan Johor Corporation',
                'contact_person' => 'Dr. Hasnul Ariffin',
                'email' => 'hasnul@yjcorp.org.my',
                'phone' => '+60 14 123 4567',
                'commencement_date' => '2020-12-01',
                'approval_date' => '2020-11-15',
                'expiry_date' => '2025-11-30', 
                'approval_status' => 'approved'
            ],
            [
                'property_id' => $komtarJbcc->id,
                'name' => 'Maxenta Cosmeceuticals Sdn Bhd',
                'contact_person' => 'Dr. Suzana Rashid',
                'email' => 'suzana@maxenta.com.my',
                'phone' => '+60 15 234 5678',
                'commencement_date' => '2021-06-15',
                'approval_date' => '2021-05-30',
                'expiry_date' => '2026-06-14', 
                'approval_status' => 'approved'
            ],
            // MART KEMPAS tenant
            [
                'property_id' => $martKempas->id,
                'name' => 'Family Jaya Enterprise',
                'contact_person' => 'Jayadev Singh',
                'email' => 'jayadev@familyjaya.com.my',
                'phone' => '+60 12 876 5432',
                'commencement_date' => '2022-01-01',
                'approval_date' => '2021-12-15',
                'expiry_date' => '2027-12-31', 
                'approval_status' => 'approved'
            ],
        ];

        // Insert all tenant records
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
                'approval_status' => $tenant['approval_status'],
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
                'status' => $statuses[array_rand($statuses)],
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
                'trustee' => 'Robert Johnson',
                'manager' => 'Emily Chen',
                'maintenance_manager' => 'Michael Lee',
                'building_manager' => 'Sarah Wong',
                'notes' => 'Routine annual inspection of the property',
                'attachment' => 'visits/skyline_a_2024_01_15.pdf', 
            ],
            [
                'property_id' => 2, // Skyline Tower B
                'date_visit' => '2024-01-16',
                'time_visit' => '14:00:00',
                'trustee' => 'Amanda Tan',
                'manager' => 'David Kim',
                'maintenance_manager' => 'Jason Ng',
                'building_manager' => 'Rachel Lim',
                'notes' => 'Routine annual inspection of the property',
                'attachment' => 'visits/skyline_b_2024_01_16.pdf', 
            ],
            [
                'property_id' => 3, // Central Business Tower
                'date_visit' => '2024-02-10',
                'time_visit' => '09:30:00',
                'trustee' => 'William Chen',
                'manager' => 'Jessica Park',
                'maintenance_manager' => 'Alex Rodriguez',
                'building_manager' => 'Karen Soh',
                'notes' => 'Inspection of newly renovated floors',
                'attachment' => 'visits/cbt_2024_02_10.pdf', 
            ],
            [
                'property_id' => 4, // Urban Heights
                'date_visit' => '2024-02-20',
                'time_visit' => '11:00:00',
                'trustee' => 'Thomas Ng',
                'manager' => 'Linda Wu',
                'maintenance_manager' => 'Robert Tan',
                'building_manager' => 'Eric Lau',
                'notes' => 'Assessment of common areas and facilities',
                'attachment' => 'visits/urban_heights_2024_02_20.pdf', 
            ],
            [
                'property_id' => 5, // Central Mall Plaza
                'date_visit' => '2024-03-05',
                'time_visit' => '10:00:00',
                'trustee' => 'Jennifer Lim',
                'manager' => 'Chris Lee',
                'maintenance_manager' => 'Daniel Choi',
                'building_manager' => 'Michelle Yap',
                'notes' => 'Inspection of retail spaces and food court',
                'attachment' => 'visits/mall_plaza_2024_03_05.pdf', 
            ],
            [
                'property_id' => 6, // Tech Manufacturing Facility
                'date_visit' => '2024-03-15',
                'time_visit' => '09:00:00',
                'trustee' => 'Mark Ibrahim',
                'manager' => 'Sophia Tan',
                'maintenance_manager' => 'Peter Wong',
                'building_manager' => 'Emma Cheng',
                'notes' => 'Safety and compliance inspection of industrial facility',
                'attachment' => 'visits/tech_facility_2024_03_15.pdf', 
            ],
            [
                'property_id' => 7, // Executive Plaza
                'date_visit' => '2024-04-10',
                'time_visit' => '14:30:00',
                'trustee' => 'Andrew Tan',
                'manager' => 'Rebecca Lee',
                'maintenance_manager' => 'Steven Ng',
                'building_manager' => 'Grace Kim',
                'notes' => 'Review of building systems and tenant improvements',
                'attachment' => 'visits/exec_plaza_2024_04_10.pdf', 
            ],
            [
                'property_id' => 8, // Beach Resort & Spa
                'date_visit' => '2024-04-20',
                'time_visit' => '11:00:00',
                'trustee' => 'Oliver Wong',
                'manager' => 'Natalie Chong',
                'maintenance_manager' => 'Ryan Lau',
                'building_manager' => 'Sophie Chen',
                'notes' => 'Inspection of resort facilities and guest accommodations',
                'attachment' => 'visits/beach_resort_2024_04_20.pdf', 
            ],
            [
                'property_id' => 9, // Central Medical Center
                'date_visit' => '2024-05-05',
                'time_visit' => '10:00:00',
                'trustee' => 'Samuel Lee',
                'manager' => 'Isabella Tan',
                'maintenance_manager' => 'Michael Chua',
                'building_manager' => 'Olivia Ng',
                'notes' => 'Review of medical facility compliance and systems',
                'attachment' => 'visits/medical_center_2024_05_05.pdf', 
            ],
            [
                'property_id' => 10, // University Research Building
                'date_visit' => '2024-05-15',
                'time_visit' => '13:00:00',
                'trustee' => 'Dr. James Wong',
                'manager' => 'Emily Lim',
                'maintenance_manager' => 'Richard Tay',
                'building_manager' => 'Sophia Chen',
                'notes' => 'Inspection of research facilities and laboratories',
                'attachment' => 'visits/uni_research_2024_05_15.pdf', 
            ],
            [
                'property_id' => 11, // Central Distribution Warehouse
                'date_visit' => '2024-06-01',
                'time_visit' => '09:00:00',
                'trustee' => 'Jonathan Ng',
                'manager' => 'Rachel Tan',
                'maintenance_manager' => 'David Lau',
                'building_manager' => 'Karen Wong',
                'notes' => 'Safety inspection of warehouse operations',
                'attachment' => 'visits/warehouse_2024_06_01.pdf', 
            ],
            [
                'property_id' => 12, // Cloud Data Center
                'date_visit' => '2024-06-15',
                'time_visit' => '10:30:00',
                'trustee' => 'Alan Cheng',
                'manager' => 'Michelle Lee',
                'maintenance_manager' => 'Kevin Tan',
                'building_manager' => 'Helen Ng',
                'notes' => 'Inspection of data center infrastructure and cooling systems',
                'attachment' => 'visits/data_center_2024_06_15.pdf', 
            ],
            [
                'property_id' => 13, // SecureSpace Center
                'date_visit' => '2024-07-01',
                'time_visit' => '11:00:00',
                'trustee' => 'Victor Wong',
                'manager' => 'Sarah Lim',
                'maintenance_manager' => 'John Tan',
                'building_manager' => 'Emma Lee',
                'notes' => 'Review of storage facility security and climate control',
                'attachment' => 'visits/securespace_2024_07_01.pdf', 
            ],
            [
                'property_id' => 1, // Skyline Tower A
                'date_visit' => '2024-09-15',
                'time_visit' => '10:00:00',
                'trustee' => 'Robert Johnson',
                'manager' => 'Emily Chen',
                'maintenance_manager' => 'Michael Lee',
                'building_manager' => 'Sarah Wong',
                'notes' => 'Follow-up inspection for maintenance issues',
                'attachment' => null, 
            ],
            [
                'property_id' => 3, // Central Business Tower
                'date_visit' => '2024-09-20',
                'time_visit' => '14:00:00',
                'trustee' => 'William Chen',
                'manager' => 'Jessica Park',
                'maintenance_manager' => 'Alex Rodriguez',
                'building_manager' => 'Karen Soh',
                'notes' => 'Tenant improvement inspection',
                'attachment' => null, 
            ]
        ];

        foreach ($siteVisits as $visit) {
            DB::table('site_visits')->insert([
                'property_id' => $visit['property_id'],
                'date_visit' => $visit['date_visit'],
                'time_visit' => $visit['time_visit'],
                'trustee' => $visit['trustee'],
                'manager' => $visit['manager'],
                'maintenance_manager' => $visit['maintenance_manager'],
                'building_manager' => $visit['building_manager'],
                'notes' => $visit['notes'],
                'attachment' => $visit['attachment'],
                'status' => $statuses[array_rand($statuses)],
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
                'status' => $statuses[array_rand($statuses)],
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
                'portfolio_id' => 1, // AL AQAR (was: Skyline Residences)
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
            ],
            [
                'portfolio_id' => 2, // AL SALAM (was: Downtown Business Center)
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
            ],
            [
                'portfolio_id' => 3, // AMANAH HARTA TANAH PNB (AHP) (was: Urban Complex)
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
            ],
            [
                'portfolio_id' => 4, // AMANAH HARTANAH BUMIPUTERA (AHB) (was: Central Shopping Mall)
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
            ],
            [
                'portfolio_id' => 1, // AL AQAR (was: Tech Industrial Park)
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
            ],
            [
                'portfolio_id' => 2, // AL SALAM (was: Executive Tower)
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
            ],
            [
                'portfolio_id' => 3, // AMANAH HARTA TANAH PNB (AHP) (was: Luxury Resort Collection)
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
            ],
            [
                'portfolio_id' => 4, // AMANAH HARTANAH BUMIPUTERA (AHB) (was: Medical Plaza)
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
            ],
            [
                'portfolio_id' => 1, // AL AQAR (was: Campus Properties)
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
            ],
            [
                'portfolio_id' => 2, // AL SALAM (was: Distribution Hub)
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
            ],
            [
                'portfolio_id' => 3, // AMANAH HARTA TANAH PNB (AHP) (was: Cloud Infrastructure)
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
            ],
            [
                'portfolio_id' => 4, // AMANAH HARTANAH BUMIPUTERA (AHB) (was: SecureSpace Facilities)
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
            ],
            [
                'portfolio_id' => 1, // AL AQAR (was: Farmland Investments)
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
            ],
            [
                'portfolio_id' => 2, // AL SALAM (was: Recreation Parks)
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
            ],
            [
                'portfolio_id' => 3, // AMANAH HARTA TANAH PNB (AHP) (was: University Accommodations)
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
                'status' => $statuses[array_rand($statuses)],
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
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => $checklist['prepared_by'],
                'verified_by' => $checklist['verified_by'],
                'remarks' => $checklist['remarks'],
                'approval_datetime' => $checklist['approval_datetime'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Appointments (New Table)
         $appointments = [
            [
                'portfolio_id' => 1, // Skyline Residences
                'party_name' => 'Master Alliance Innovations Sdn Bhd',
                'date_of_approval' => '2024-03-18',
                'appointment_title' => 'CONSULTANT FOR PUBLICATION OF ANNUAL REPORT',
                'appointment_description' => 'APPOINTMENT OF MASTER ALLIANCE INNOVATIONS SDN BHD AS CONSULTANT FOR PUBLICATION OF AL-SALAM REIT 2023 ANNUAL REPORT',
                'estimated_amount' => 64200.00,
                'remarks' => 'Annual appointment for report preparation',
                'year' => 2024,
                'reference_no' => 'APP/2024/001',
            ],
            [
                'portfolio_id' => 1, // Skyline Residences
                'party_name' => 'CONSULTANT',
                'date_of_approval' => '2024-03-29',
                'appointment_title' => 'CONSULTANT FOR AGM',
                'appointment_description' => 'PROPOSED APPOINTMENT OF CONSULTANT FOR AGM FOR AL-SALAM REIT',
                'estimated_amount' => 32681.20,
                'remarks' => 'For AGM coordination and execution',
                'year' => 2024,
                'reference_no' => 'APP/2024/002',
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'party_name' => 'KAF INVESTMENT BANK BERHAD ABDUL RAMAN SAAD & ASSOCIATES',
                'date_of_approval' => '2024-04-08',
                'appointment_title' => 'MANDATE FOR RECURRENT RELATED PARTY TRANSACTION',
                'appointment_description' => 'PROPOSED UNITHOLDERS MANDATE FOR RECURRENT RELATED PARTY TRANSACTION OF A REVENUE OR TRADING NATURE FOR AL-SALAM REIT REAL ESTATE INVESTMENT TRUST ("AL-SALAM")',
                'estimated_amount' => 53000.00,
                'remarks' => 'Required for regulatory compliance',
                'year' => 2024,
                'reference_no' => 'APP/2024/003',
            ],
            [
                'portfolio_id' => 3, // Urban Complex
                'party_name' => 'KOMTAR JBCC, JOHOR',
                'date_of_approval' => '2024-04-24',
                'appointment_title' => 'TRADEMARK RENEWAL',
                'appointment_description' => 'RENEWAL, RECORDAL AND REGISTRATION OF TRADEMARK FOR KOMTAR JBCC, JOHOR ("JBCC") ("Proposed Exercise")',
                'estimated_amount' => 15000.00,
                'remarks' => 'Intellectual property protection',
                'year' => 2024,
                'reference_no' => 'APP/2024/005',
            ],
            [
                'portfolio_id' => 1, // Skyline Residences
                'party_name' => 'AL-SALAM REIT',
                'date_of_approval' => '2024-05-10',
                'appointment_title' => 'AGM COST',
                'appointment_description' => 'PROPOSED COST FOR ANNUAL GENERAL MEETING OF AL-AQAR AND AL-SALAM REIT 2024 ("Proposed Cost")',
                'estimated_amount' => 50000.00,
                'remarks' => 'Annual general meeting expenses',
                'year' => 2024,
                'reference_no' => 'APP/2024/006',
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'party_name' => 'DELOITTE TAX SERVICES SDN BHD',
                'date_of_approval' => '2024-05-23',
                'appointment_title' => 'TAX SERVICES APPOINTMENT',
                'appointment_description' => 'PROPOSED APPOINTMENT OF DELOITTE TAX SERVICES SDN BHD',
                'estimated_amount' => 27500.00,
                'remarks' => 'Tax advisory and compliance services',
                'year' => 2024,
                'reference_no' => 'APP/2024/007',
            ]
        ];

        foreach ($appointments as $appointment) {
            DB::table('appointments')->insert([
                'portfolio_id' => $appointment['portfolio_id'],
                'party_name' => $appointment['party_name'],
                'date_of_approval' => $appointment['date_of_approval'],
                'appointment_title' => $appointment['appointment_title'],
                'appointment_description' => $appointment['appointment_description'],
                'estimated_amount' => $appointment['estimated_amount'],
                'remarks' => $appointment['remarks'],
                'attachment' => null,
                'year' => $appointment['year'],
                'reference_no' => $appointment['reference_no'],
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'approval_datetime' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Seed Approval Forms (New Table)
        $approvalForms = [
            [
                'portfolio_id' => 1, // Skyline Residences
                'property_id' => null,
                'form_number' => '1',
                'form_title' => '@Mart Kempas - CAPEX 24-2023(PA)',
                'form_category' => 'CAPEX',
                'reference_code' => 'CAPEX/2023/001',
                'received_date' => '2024-01-05',
                'send_date' => '2024-01-15',
                'location' => 'Finance Department',
                'description' => 'Capital expenditure approval form for Mart Kempas',
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center 
                'property_id' => null,
                'form_number' => '1',
                'form_title' => 'Komtar JBCC - Admin-23-06',
                'form_category' => 'Admin',
                'reference_code' => 'ADMIN/2023/006',
                'received_date' => '2024-01-05',
                'send_date' => '2024-01-15',
                'location' => 'Admin Department',
                'description' => 'Administrative approval form for Komtar JBCC operations',
            ],
            [
                'portfolio_id' => 3, // Urban Complex
                'property_id' => null,
                'form_number' => '1',
                'form_title' => 'Komtar JBCC - TECH - 23-188',
                'form_category' => 'Tech',
                'reference_code' => 'TECH/2023/188',
                'received_date' => '2023-12-21',
                'send_date' => '2024-01-15',
                'location' => 'IT Department',
                'description' => 'Technology implementation approval for Komtar JBCC',
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'property_id' => null,
                'form_number' => '1',
                'form_title' => 'Komtar JBCC - LEASING-12-2023 (Marrybrown)',
                'form_category' => 'Leasing',
                'reference_code' => 'LEASE/2023/012',
                'received_date' => '2024-01-03',
                'send_date' => '2024-01-15',
                'location' => 'Leasing Department',
                'description' => 'Lease agreement approval for Marrybrown at Komtar JBCC',
            ],
            [
                'portfolio_id' => 1, // Skyline Residences
                'property_id' => null,
                'form_number' => '1',
                'form_title' => '@Mart Kempas - LEASING-056-2023',
                'form_category' => 'Leasing',
                'reference_code' => 'LEASE/2023/056',
                'received_date' => '2023-12-21',
                'send_date' => '2024-01-15',
                'location' => 'Leasing Department',
                'description' => 'Lease agreement approval for Mart Kempas',
            ],
            [
                'portfolio_id' => 3, // Urban Complex
                'property_id' => null,
                'form_number' => '1',
                'form_title' => 'Menara Komtar - LSG 23/8',
                'form_category' => 'LSG',
                'reference_code' => 'LSG/2023/008',
                'received_date' => '2023-12-21',
                'send_date' => '2024-01-15',
                'location' => 'Legal Department',
                'description' => 'Legal services approval for Menara Komtar',
            ],
            [
                'portfolio_id' => 3, // Urban Complex
                'property_id' => null,
                'form_number' => '2',
                'form_title' => 'Menara Komtar - LSG 23/38',
                'form_category' => 'LSG',
                'reference_code' => 'LSG/2023/038',
                'received_date' => '2023-12-21',
                'send_date' => '2024-01-15',
                'location' => 'Legal Department',
                'description' => 'Legal services approval for Menara Komtar operations',
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'property_id' => null,
                'form_number' => '1',
                'form_title' => 'Komtar JBCC - Leasing-2023-11-1 (New Trading Name - FRKE)',
                'form_category' => 'Leasing',
                'reference_code' => 'LEASE/2023/111',
                'received_date' => '2024-01-16',
                'send_date' => '2024-01-23',
                'location' => 'Leasing Department',
                'description' => 'Lease agreement approval for new tenant FRKE at Komtar JBCC',
            ],
            [
                'portfolio_id' => 2, // Downtown Business Center
                'property_id' => null,
                'form_number' => '2',
                'form_title' => 'Komtar JBCC - Leasing-2023-11-2 (New Trading Name - POULET)',
                'form_category' => 'Leasing',
                'reference_code' => 'LEASE/2023/112',
                'received_date' => '2024-01-16',
                'send_date' => '2024-01-23',
                'location' => 'Leasing Department',
                'description' => 'Lease agreement approval for new tenant POULET at Komtar JBCC',
            ]
        ];

        foreach ($approvalForms as $form) {
            DB::table('approval_forms')->insert([
                'portfolio_id' => $form['portfolio_id'],
                'property_id' => $form['property_id'],
                'form_number' => $form['form_number'],
                'form_title' => $form['form_title'],
                'form_category' => $form['form_category'],
                'reference_code' => $form['reference_code'],
                'received_date' => $form['received_date'],
                'send_date' => $form['send_date'],
                'attachment' => null,
                'location' => $form['location'],
                'description' => $form['description'],
                'remarks' => null,
                'status' => $statuses[array_rand($statuses)],
                'prepared_by' => 'System Admin',
                'verified_by' => 'System Verifier',
                'approval_datetime' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}