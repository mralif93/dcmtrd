<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\Bank;
use App\Models\FinancialType;
use App\Models\PortfolioType;

class DefaultReitsSeeder extends Seeder
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
      'withdrawn' => 'bg-gray-100 text-gray-800',
      'completed' => 'bg-green-100 text-green-800',
      'scheduled' => 'bg-blue-100 text-blue-800',
      'cancelled' => 'bg-red-100 text-red-800',
      'in progress' => 'bg-yellow-100 text-yellow-800',
      'on hold' => 'bg-gray-100 text-gray-800',
      'reviewing' => 'bg-blue-100 text-blue-800',
      'approved' => 'bg-green-100 text-green-800',
      'expired' => 'bg-red-100 text-red-800',
    ];

    // Define banks
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

    // Define financial types
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

    // Define portfolio types
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
  }
}