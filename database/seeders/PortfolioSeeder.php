<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($portfolios as &$portfolio) {
            $portfolio += [
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('portfolios')->insert($portfolios);
    }
}