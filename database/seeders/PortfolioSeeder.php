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
                'annual_report' => null,
                'trust_deed_document' => null,
                'insurance_document' => null,
                'valuation_report' => null,
            ],
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AL SALAM',
                'annual_report' => null,
                'trust_deed_document' => null,
                'insurance_document' => null,
                'valuation_report' => null,
            ],
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AMANAH HARTA TANAH PNB (AHP)',
                'annual_report' => null,
                'trust_deed_document' => null,
                'insurance_document' => null,
                'valuation_report' => null,
            ],
            [
                'portfolio_types_id' => 1,
                'portfolio_name' => 'AMANAH HARTANAH BUMIPUTERA (AHB)',
                'annual_report' => null,
                'trust_deed_document' => null,
                'insurance_document' => null,
                'valuation_report' => null,
            ],
        ];

        foreach ($portfolios as &$portfolio) {
            $portfolio += [
                'status' => 'Draft',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('portfolios')->insert($portfolios);
    }
}
