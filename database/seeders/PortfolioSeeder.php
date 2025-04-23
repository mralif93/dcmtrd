<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Models
use App\Models\Portfolio;

class PortfolioSeeder extends Seeder
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
      'scheduled' => 'bg-yellow-100 text-yellow-800',
      'cancelled' => 'bg-red-100 text-red-800',
      'in progress' => 'bg-blue-100 text-blue-800',
      'on hold' => 'bg-gray-100 text-gray-800',
      'reviewing' => 'bg-yellow-100 text-yellow-800',
      'approved' => 'bg-green-100 text-green-800',
      'expired' => 'bg-red-100 text-red-800',
    ];

    // Seed Portfolios - MODIFIED: Adding all 15 portfolios here
    $portfolios = [
        [
            'portfolio_types_id' => 1,
            'portfolio_name' => 'AL AQAR',
            'annual_report' => 'annual_reports/al_aqar_2024.pdf',
            'trust_deed_document' => 'trust_deeds/al_aqar_trust.pdf',
            'insurance_document' => 'insurance/al_aqar_insurance.pdf',
            'valuation_report' => 'valuations/al_aqar_valuation.pdf',
            'status' => 'active'
        ],
        [
            'portfolio_types_id' => 1,
            'portfolio_name' => 'AL SALAM',
            'annual_report' => 'annual_reports/al_salam_2024.pdf',
            'trust_deed_document' => 'trust_deeds/al_salam_trust.pdf',
            'insurance_document' => 'insurance/al_salam_insurance.pdf',
            'valuation_report' => 'valuations/al_salam_valuation.pdf',
            'status' => 'active'
        ],
        [
            'portfolio_types_id' => 1,
            'portfolio_name' => 'AMANAH HARTA TANAH PNB (AHP)',
            'annual_report' => 'annual_reports/amanah_harta_tanah_pnb_2024.pdf',
            'trust_deed_document' => 'trust_deeds/amanah_harta_tanah_pnb_trust.pdf',
            'insurance_document' => 'insurance/amanah_harta_tanah_pnb_insurance.pdf',
            'valuation_report' => 'valuations/amanah_harta_tanah_pnb_valuation.pdf',
            'status' => 'pending'
        ],
        [
            'portfolio_types_id' => 1,
            'portfolio_name' => 'AMANAH HARTANAH BUMIPUTERA (AHB)',
            'annual_report' => 'annual_reports/amanah_hartanah_bumiputera_2024.pdf',
            'trust_deed_document' => 'trust_deeds/amanah_hartanah_bumiputera_trust.pdf',
            'insurance_document' => 'insurance/amanah_hartanah_bumiputera_insurance.pdf',
            'valuation_report' => 'valuations/amanah_hartanah_bumiputera_valuation.pdf',
            'status' => 'pending'
        ],
    ];

    // Create portfolios
    foreach ($portfolios as $portfolio) {
        DB::table('portfolios')->insert([
            'portfolio_types_id' => $portfolio['portfolio_types_id'],
            'portfolio_name' => $portfolio['portfolio_name'],
            'annual_report' => $portfolio['annual_report'],
            'trust_deed_document' => $portfolio['trust_deed_document'],
            'insurance_document' => $portfolio['insurance_document'],
            'valuation_report' => $portfolio['valuation_report'],
            'status' => $portfolio['status'],
            'prepared_by' => 'System Admin',
            'verified_by' => 'System Verifier',
            'approval_datetime' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
  }
}