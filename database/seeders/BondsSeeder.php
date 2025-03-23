<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BondsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Issuers with new data
        $issuers = [
            ['issuer_short_name' => 'PIBB', 'issuer_name' => 'PUBLIC ISLAMIC BANK BERHAD', 'registration_number' => '14328-V'],
            ['issuer_short_name' => 'RHBBANK', 'issuer_name' => 'RHB BANK BERHAD', 'registration_number' => '006171M'],
            ['issuer_short_name' => 'JEP', 'issuer_name' => 'JIMAH EAST POWER SDN BHD', 'registration_number' => '1053111D'],
            ['issuer_short_name' => 'SUNREIT MTN', 'issuer_name' => 'SUNREIT UNRATED BOND BERHAD', 'registration_number' => '977739X'],
            ['issuer_short_name' => 'PRASARANA', 'issuer_name' => 'PRASARANA MALAYSIA BERHAD', 'registration_number' => '467220U'],
            ['issuer_short_name' => 'SPG', 'issuer_name' => 'SOUTHERN POWER GENERATION SDN BHD', 'registration_number' => '1198060T'],
            ['issuer_short_name' => 'PUBLIC', 'issuer_name' => 'PUBLIC BANK BERHAD', 'registration_number' => '006463H'],
            ['issuer_short_name' => 'RHBA', 'issuer_name' => 'RHB ISLAMIC BANK BERHAD', 'registration_number' => '680329A'],
            ['issuer_short_name' => 'MENARA ABS', 'issuer_name' => 'MENARA ABS BERHAD', 'registration_number' => '669499-X'],
            ['issuer_short_name' => 'MALAKOFF POW', 'issuer_name' => 'MALAKOFF POWER BERHAD', 'registration_number' => '909003H'],
            ['issuer_short_name' => 'SUKE', 'issuer_name' => 'PROJEK LINTASAN SUNGAI BESI-ULU KLANG SDN. BHD.', 'registration_number' => '942090U'],
            ['issuer_short_name' => 'PNBMV', 'issuer_name' => 'PNB MERDEKA VENTURES SDN. BERHAD', 'registration_number' => '517991A'],
            ['issuer_short_name' => 'TRUE ASCEND', 'issuer_name' => 'TRUE ASCEND SDN BHD', 'registration_number' => '1232851P'],
            ['issuer_short_name' => 'RADIMAX', 'issuer_name' => 'RADIMAX GROUP SDN BHD', 'registration_number' => '219269-W'],
            ['issuer_short_name' => 'CENDANA', 'issuer_name' => 'CENDANA SEJATI SDN BHD', 'registration_number' => '1051796P'],
            ['issuer_short_name' => 'PLSA', 'issuer_name' => 'PROJEK LINTASAN SHAH ALAM SDN BHD', 'registration_number' => '654187M'],
            ['issuer_short_name' => 'MASTEEL', 'issuer_name' => 'MALAYSIA STEEL WORKS (KL) BHD', 'registration_number' => '007878V'],
            ['issuer_short_name' => 'BRECON', 'issuer_name' => 'BRECON SYNERGY SDN BHD', 'registration_number' => '1161345M'],
            ['issuer_short_name' => 'AZRB CAPITAL', 'issuer_name' => 'AZRB CAPITAL SDN BHD', 'registration_number' => '1333273A'],
            ['issuer_short_name' => 'AEON', 'issuer_name' => 'AEON CREDIT SERVICE (M) BERHAD', 'registration_number' => '412767-V'],
            ['issuer_short_name' => 'TG EXCEL', 'issuer_name' => 'TG EXCELLENCE BERHAD', 'registration_number' => '201901033302'],
            ['issuer_short_name' => 'HUME', 'issuer_name' => 'HUME CEMENT INDUSTRIES BERHAD', 'registration_number' => '198001008443'],
            ['issuer_short_name' => 'FELDA', 'issuer_name' => 'FEDERAL LAND DEVELOPMENT AUTHORITY', 'registration_number' => '0'],
            ['issuer_short_name' => 'CCB', 'issuer_name' => 'CELLCO CAPITAL BERHAD', 'registration_number' => '1388008K'],
            ['issuer_short_name' => 'OSK RATED', 'issuer_name' => 'OSK RATED BOND SDN. BHD.', 'registration_number' => '1382748P'],
            ['issuer_short_name' => 'KULIM TECH', 'issuer_name' => 'KULIM TECHNOLOGY PARK CORPORATION SDN.BHD.', 'registration_number' => '044351D'],
            ['issuer_short_name' => 'MDV', 'issuer_name' => 'MALAYSIA DEBT VENTURES BERHAD', 'registration_number' => '578113-A'],
            ['issuer_short_name' => 'TNBPGSB', 'issuer_name' => 'TNB POWER GENERATION SDN. BHD.', 'registration_number' => '1336401D'],
            ['issuer_short_name' => 'TSM', 'issuer_name' => 'THP SURIA MEKAR SDN BHD', 'registration_number' => '419456K'],
            ['issuer_short_name' => 'EMSB', 'issuer_name' => 'EDOTCO MALAYSIA SDN. BHD.', 'registration_number' => '198501016343'],
            ['issuer_short_name' => 'ALAMFLORA', 'issuer_name' => 'ALAM FLORA SDN BHD', 'registration_number' => '789345-EE'],
            ['issuer_short_name' => 'KUSB', 'issuer_name' => 'KWASA UTAMA SDN BHD', 'registration_number' => '201401013872'],
            ['issuer_short_name' => 'WORLJWTE', 'issuer_name' => 'WORLWIDE JERAM WTE SDN BHD', 'registration_number' => '567890-GG'],
            ['issuer_short_name' => 'WORLDGREEN', 'issuer_name' => 'WORLDWIDE ENVIROGREEN SDN BHD', 'registration_number' => '678901-HH'],
            ['issuer_short_name' => 'UEM OLIVE', 'issuer_name' => 'UEM OLIVE CAPITAL BERHAD', 'registration_number' => '202301021212'],
            ['issuer_short_name' => 'SDESB', 'issuer_name' => 'SIME DARBY ENTERPRISE SDN. BHD.', 'registration_number' => '202301022601'],
            ['issuer_short_name' => 'GECM', 'issuer_name' => 'GREAT EASTERN CAPITAL (MALAYSIA) SDN BHD', 'registration_number' => '196601000153'],
            ['issuer_short_name' => 'BLBRSB', 'issuer_name' => 'BERJAYA LANGKAWI BEACH RESORT SDN BHD', 'registration_number' => '232483P'],
            ['issuer_short_name' => 'PANTAI', 'issuer_name' => 'PANTAI HOLDINGS SDN BHD', 'registration_number' => '197201000211'],
            ['issuer_short_name' => 'KIM LOONG', 'issuer_name' => 'KIM LOONG RESOURCES BERHAD', 'registration_number' => '197501000991'],
            ['issuer_short_name' => 'TDM', 'issuer_name' => 'TDM BERHAD', 'registration_number' => '196501000477'],
        ];

        $issuersData = [];
        foreach ($issuers as $issuer) {
            $issuersData[] = [
                'issuer_short_name' => $issuer['issuer_short_name'],
                'issuer_name' => $issuer['issuer_name'],
                'registration_number' => $issuer['registration_number'],
                'debenture' => 'Medium Term Notes', // Default debenture type
                'trustee_role_1' => 'Bond Trustee',
                'trustee_role_2' => 'Security Trustee',
                'trust_deed_date' => Carbon::now()->subMonths(rand(1, 24))->format('Y-m-d'), // Random past date
                'trust_amount_escrow_sum' => rand(500000000, 1000000000) . '.00',
                'no_of_share' => rand(1000000, 2000000),
                'outstanding_size' => rand(500000000, 1000000000) . '.00',
                'status' => 'Active',
                'prepared_by' => 'System',
                'verified_by' => 'System Verifier',
                'remarks' => 'Auto-generated issuer data',
                'approval_datetime' => Carbon::now()->subDays(rand(10, 60))->format('Y-m-d H:i:s'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('issuers')->insert($issuersData);

        // Create a sample bond for each issuer
        $bonds = [];
        $issuerIds = DB::table('issuers')->pluck('id', 'issuer_short_name')->toArray();
        
        // Define categories and sub-categories for bonds
        $categories = ['Conventional', 'Islamic', 'Green Bond', 'Sukuk'];
        $subCategories = [
            'Medium Term Notes', 'Senior Notes', 'Subordinated Notes', 
            'Sukuk Wakalah', 'Sukuk Murabahah', 'Green Sukuk',
            'Corporate Bonds', 'Perpetual Bonds'
        ];
        $statuses = ['Active', 'Pending', 'Maturing', 'Redeemed', 'Suspended', 'Draft', 'Defaulted'];
        $ratings = ['AAA', 'AA1', 'AA2', 'AA3', 'A1', 'A2', 'A3', 'BBB1', 'BBB2', 'BBB3'];
        $couponTypes = ['Fixed', 'Floating', 'Zero Coupon', 'Step-up'];
        $couponFrequencies = ['Annual', 'Semi-annual', 'Quarterly', 'Monthly'];
        
        $bondCount = 1; // Counter for bond IDs
        
        foreach ($issuerIds as $shortName => $issuerId) {
            // Generate 1-3 bonds per issuer
            $numBonds = rand(1, 3);
            
            for ($i = 0; $i < $numBonds; $i++) {
                $issueYear = rand(2020, 2024);
                $issueMonth = rand(1, 12);
                $issueDay = rand(1, 28);
                $issueDate = "$issueYear-" . sprintf("%02d", $issueMonth) . "-" . sprintf("%02d", $issueDay);
                
                $tenor = rand(3, 15); // 3 to 15 year tenor
                $maturityDate = Carbon::parse($issueDate)->addYears($tenor)->format('Y-m-d');
                $currentDate = Carbon::now();
                $residualTenor = Carbon::parse($issueDate)->diffInDays($maturityDate) / 365.0;
                
                $category = $categories[array_rand($categories)];
                $subCategory = $subCategories[array_rand($subCategories)];
                
                if ($category == 'Islamic' || $category == 'Sukuk') {
                    // Make sure Islamic bonds get Islamic sub-categories
                    $subCategory = in_array($subCategory, ['Sukuk Wakalah', 'Sukuk Murabahah', 'Green Sukuk']) 
                        ? $subCategory : 'Sukuk Wakalah';
                }
                
                $couponRate = (rand(300, 650) / 100); // 3.00% to 6.50%
                $principal = rand(3, 10) * 100000000; // 300M to 1B
                
                $status = $statuses[array_rand($statuses)];
                // Set more recent bonds as active or pending
                if ($issueYear >= 2023) {
                    $status = rand(0, 1) ? 'Active' : 'Pending';
                }
                
                // Generate ISIN and stock codes
                $isinCode = 'MYA' . (1000000 + $bondCount);
                $stockCode = substr($shortName, 0, 4) . sprintf("%02d", $i + 1);
                $instrumentCode = substr($shortName, 0, 3) . sprintf("%02d", $issueMonth) . substr($maturityDate, 2, 2);
                
                $bonds[] = [
                    'bond_sukuk_name' => $shortName . ' ' . $subCategory . ' ' . $issueYear,
                    'sub_name' => 'Series ' . ($i + 1),
                    'rating' => $ratings[array_rand($ratings)],
                    'category' => $category,
                    'principal' => $principal,
                    'isin_code' => $isinCode,
                    'stock_code' => $stockCode,
                    'instrument_code' => $instrumentCode,
                    'sub_category' => $subCategory,
                    'issue_date' => $issueDate,
                    'maturity_date' => $maturityDate,
                    'coupon_rate' => $couponRate,
                    'coupon_type' => $couponTypes[array_rand($couponTypes)],
                    'coupon_frequency' => $couponFrequencies[array_rand($couponFrequencies)],
                    'day_count' => 'Actual/365',
                    'issue_tenure_years' => $tenor,
                    'residual_tenure_years' => $residualTenor,
                    'last_traded_yield' => $couponRate - (rand(-30, 30) / 100), // Random spread around coupon
                    'last_traded_price' => 100 + (rand(-200, 200) / 100), // 98.00 to 102.00
                    'last_traded_amount' => rand(5, 20) * 1000000, // 5M to 20M
                    'last_traded_date' => Carbon::now()->subDays(rand(1, 60))->format('Y-m-d'),
                    'coupon_accrual' => Carbon::now()->subDays(rand(1, 90))->format('Y-m-d'),
                    'prev_coupon_payment_date' => Carbon::parse($issueDate)->addMonths($i * 3)->format('Y-m-d'),
                    'first_coupon_payment_date' => Carbon::parse($issueDate)->addMonths(6)->format('Y-m-d'),
                    'next_coupon_payment_date' => Carbon::now()->addMonths(rand(1, 6))->format('Y-m-d'),
                    'last_coupon_payment_date' => $maturityDate,
                    'amount_issued' => $principal,
                    'amount_outstanding' => $status == 'Redeemed' ? 0 : $principal,
                    'lead_arranger' => $shortName . ' Investment Bank',
                    'facility_agent' => $shortName . ' Investment Bank',
                    'facility_code' => $shortName . '-00' . ($i + 1),
                    'status' => $status,
                    'prepared_by' => 'System',
                    'verified_by' => 'System Verifier',
                    'remarks' => 'Auto-generated bond data',
                    'approval_datetime' => Carbon::now()->subDays(rand(10, 60))->format('Y-m-d H:i:s'),
                    'issuer_id' => $issuerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $bondCount++;
            }
        }

        DB::table('bonds')->insert($bonds);

        // Seed Rating Movements for a subset of bonds
        $ratingMovements = [];
        $bondIds = DB::table('bonds')->pluck('id')->toArray();
        $ratingAgencies = ['RAM', 'MARC', 'Moody\'s', 'S&P', 'Fitch'];
        $ratingActions = ['New', 'Affirmed', 'Upgraded', 'Downgraded'];
        $ratingOutlooks = ['Stable', 'Positive', 'Negative', 'Developing'];
        $ratingWatches = ['None', 'Positive', 'Negative', 'Developing'];
        
        foreach ($bondIds as $bondId) {
            // Generate 1-3 rating movements for each bond
            $numRatings = rand(1, 3);
            $baseDate = Carbon::now()->subYears(2);
            
            for ($i = 0; $i < $numRatings; $i++) {
                $ratingDate = $baseDate->copy()->addMonths($i * 6 + rand(0, 3));
                $ratingAction = $i == 0 ? 'New' : $ratingActions[array_rand($ratingActions)];
                
                $ratingMovements[] = [
                    'rating_agency' => $ratingAgencies[array_rand($ratingAgencies)],
                    'effective_date' => $ratingDate->format('Y-m-d'),
                    'rating_tenure' => 'Long Term',
                    'rating' => $ratings[array_rand($ratings)],
                    'rating_action' => $ratingAction,
                    'rating_outlook' => $ratingOutlooks[array_rand($ratingOutlooks)],
                    'rating_watch' => $ratingWatches[array_rand($ratingWatches)],
                    'bond_id' => $bondId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('rating_movements')->insert($ratingMovements);

        // Seed Payment Schedules for active bonds
        $paymentSchedules = [];
        $activeBonds = DB::table('bonds')
                          ->whereIn('status', ['Active', 'Maturing', 'Suspended'])
                          ->get(['id', 'coupon_frequency', 'coupon_rate', 'issue_date', 'maturity_date']);
        
        foreach ($activeBonds as $bond) {
            $interval = 12; // Default to annual
            
            if ($bond->coupon_frequency == 'Semi-annual') {
                $interval = 6;
            } elseif ($bond->coupon_frequency == 'Quarterly') {
                $interval = 3;
            } elseif ($bond->coupon_frequency == 'Monthly') {
                $interval = 1;
            }
            
            $issueDate = Carbon::parse($bond->issue_date);
            $maturityDate = Carbon::parse($bond->maturity_date);
            $currentDate = Carbon::now();
            
            // Create past and future payment schedules
            $paymentDate = $issueDate->copy();
            
            while ($paymentDate->lte($maturityDate)) {
                $startDate = $paymentDate->copy();
                $paymentDate->addMonths($interval);
                
                if ($paymentDate->gte($currentDate->copy()->subMonths(6)) && 
                    $paymentDate->lte($currentDate->copy()->addMonths(12))) {
                    $paymentSchedules[] = [
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $paymentDate->copy()->subDays(1)->format('Y-m-d'),
                        'payment_date' => $paymentDate->format('Y-m-d'),
                        'ex_date' => $paymentDate->copy()->subDays(7)->format('Y-m-d'),
                        'coupon_rate' => $bond->coupon_rate,
                        'adjustment_date' => null,
                        'bond_id' => $bond->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        DB::table('payment_schedules')->insert($paymentSchedules);

        // Seed Redemptions and related tables
        $redemptions = [];
        $lockoutPeriods = [];
        $callSchedules = [];
        
        $redemptionIndex = 1; // Counter for redemption IDs
        
        foreach ($activeBonds as $bond) {
            $issueDate = Carbon::parse($bond->issue_date);
            $maturityDate = Carbon::parse($bond->maturity_date);
            
            // Generate redemption
            $allowPartialCall = rand(0, 1) ? true : false;
            $redeemNearestDenomination = rand(0, 1) ? true : false;
            
            $redemptions[] = [
                'last_call_date' => $maturityDate->copy()->subMonths(rand(0, 6))->format('Y-m-d'),
                'allow_partial_call' => $allowPartialCall,
                'redeem_nearest_denomination' => $redeemNearestDenomination,
                'bond_id' => $bond->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Generate lockout period
            $lockoutEndDate = $issueDate->copy()->addYears(rand(1, 3));
            
            $lockoutPeriods[] = [
                'start_date' => $issueDate->format('Y-m-d'),
                'end_date' => $lockoutEndDate->format('Y-m-d'),
                'redemption_id' => $redemptionIndex,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Generate call schedules
            $callStartDate = $lockoutEndDate->copy()->addDays(1);
            $callEndDate = $callStartDate->copy()->addYears(1);
            
            while ($callEndDate->lt($maturityDate)) {
                $callSchedules[] = [
                    'start_date' => $callStartDate->format('Y-m-d'),
                    'end_date' => $callEndDate->format('Y-m-d'),
                    'call_price' => (100 + rand(0, 3) + (rand(0, 75) / 100)), // 100.00 to 103.75
                    'redemption_id' => $redemptionIndex,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $callStartDate = $callEndDate->copy()->addDays(1);
                $callEndDate = $callStartDate->copy()->addYears(1);
            }
            
            // Final call period to maturity
            if ($callStartDate->lt($maturityDate)) {
                $callSchedules[] = [
                    'start_date' => $callStartDate->format('Y-m-d'),
                    'end_date' => $maturityDate->format('Y-m-d'),
                    'call_price' => (100 + (rand(0, 75) / 100)), // 100.00 to 100.75
                    'redemption_id' => $redemptionIndex,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            $redemptionIndex++;
        }

        DB::table('redemptions')->insert($redemptions);
        DB::table('lockout_periods')->insert($lockoutPeriods);
        DB::table('call_schedules')->insert($callSchedules);

        // Seed Trading Activities
        $tradingActivities = [];
        $activeBondIds = DB::table('bonds')
                            ->whereIn('status', ['Active', 'Maturing', 'Suspended'])
                            ->pluck('id')
                            ->toArray();
        
        foreach ($activeBondIds as $bondId) {
            // Generate 3-10 trading activities per bond
            $numTrades = rand(3, 10);
            $bond = DB::table('bonds')->where('id', $bondId)->first();
            
            for ($i = 0; $i < $numTrades; $i++) {
                $tradeDate = Carbon::now()->subDays(rand(1, 90));
                $inputHour = rand(9, 16);
                $inputMinute = rand(0, 59);
                $inputTime = sprintf("%02d:%02d:00", $inputHour, $inputMinute);
                
                $price = 100 + (rand(-200, 200) / 100); // 98.00 to 102.00
                $yield = $bond->coupon_rate - (rand(-50, 50) / 100); // +/- 0.5% from coupon
                
                $tradingActivities[] = [
                    'trade_date' => $tradeDate->format('Y-m-d'),
                    'input_time' => $inputTime,
                    'amount' => rand(3, 20) * 1000000, // 3M to 20M
                    'price' => $price,
                    'yield' => $yield,
                    'value_date' => $tradeDate->copy()->addDays(2)->format('Y-m-d'),
                    'bond_id' => $bondId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('trading_activities')->insert($tradingActivities);

        // Seed Announcements
        $announcements = [];
        
        // Get a subset of issuers for announcements
        $issuersList = DB::table('issuers')->inRandomOrder()->limit(15)->get(['id', 'issuer_short_name']);
        
        $categories = ['Corporate', 'Bond Specific', 'Rating', 'Credit Event', 'Regulatory'];
        $subCategories = [
            'Financial Results', 'Dividend', 'New Issuance', 'Corporate Exercise',
            'Coupon Payment', 'Trading Suspension', 'Regulatory Approval', 'Early Redemption',
            'Rating Affirmation', 'Rating Action', 'Default', 'Covenant Breach'
        ];
        
        foreach ($issuersList as $issuer) {
            // Generate 1-3 announcements per issuer
            $numAnnouncements = rand(1, 3);
            
            for ($i = 0; $i < $numAnnouncements; $i++) {
                $announcementDate = Carbon::now()->subDays(rand(1, 60));
                $category = $categories[array_rand($categories)];
                $subCategory = $subCategories[array_rand($subCategories)];
                
                $title = $issuer->issuer_short_name . ' ' . $subCategory . ' Announcement';
                $description = 'Details regarding ' . $subCategory . ' for ' . $issuer->issuer_short_name;
                
                $announcements[] = [
                    'announcement_date' => $announcementDate->format('Y-m-d'),
                    'category' => $category,
                    'sub_category' => $subCategory,
                    'title' => $title,
                    'description' => $description,
                    'content' => 'This is an auto-generated announcement for ' . $issuer->issuer_short_name . 
                                ' regarding ' . $subCategory . '. Detailed information would be provided here.',
                    'attachment' => strtolower($issuer->issuer_short_name) . '_' . strtolower(str_replace(' ', '_', $subCategory)) . '.pdf',
                    'source' => rand(0, 1) ? 'Bursa Malaysia' : $issuer->issuer_short_name,
                    'prepared_by' => 'System',
                    'verified_by' => rand(0, 1) ? 'System Verifier' : null,
                    'remarks' => 'Auto-generated announcement',
                    'approval_datetime' => $announcementDate->copy()->subDays(1)->format('Y-m-d H:i:s'),
                    'issuer_id' => $issuer->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('announcements')->insert($announcements);

        // Seed Facility Informations
        $facilityInformations = [];
        $issuerIds = DB::table('issuers')->pluck('id', 'issuer_short_name')->toArray();
        
        foreach ($issuerIds as $shortName => $issuerId) {
            // Only create facility for some issuers
            if (rand(0, 2) > 0) { // 2/3 chance to create facility
                $facilityCode = $shortName . '-001';
                $facilityNumber = $shortName . '/' . rand(2020, 2024) . '/001';
                $facilityName = $shortName . ' ' . (rand(0, 1) ? 'Medium Term Notes Program' : 'Sukuk Program');
                
                $principleType = rand(0, 1) ? 'Conventional' : 'Islamic';
                $islamicConcept = $principleType == 'Islamic' ? 
                    (rand(0, 1) ? 'Wakalah' : 'Murabahah') : null;
                
                $maturityYear = rand(2025, 2035);
                $maturityDate = $maturityYear . '-' . sprintf("%02d", rand(1, 12)) . '-' . sprintf("%02d", rand(1, 28));
                
                $instrument = $principleType == 'Islamic' ? 'Sukuk' : 
                    (rand(0, 2) == 0 ? 'Medium Term Notes' : (rand(0, 1) ? 'Senior Notes' : 'Subordinated Notes'));
                
                $instrumentType = rand(0, 3) == 0 ? 'Tier 2 Capital' : 'Senior Unsecured';
                $guaranteed = rand(0, 5) == 0; // 1/6 chance to be guaranteed
                $totalGuaranteed = $guaranteed ? (rand(5, 10) * 100000000) . '.00' : null;
                
                $indicator = rand(0, 3) == 0 ? 'Corporate' : 'Financial Institution';
                $facilityRating = $ratings[array_rand($ratings)];
                
                $facilityAmount = rand(10, 50) * 100000000 . '.00';
                $availableLimit = rand(5, 10) * 100000000 . '.00';
                $outstandingAmount = (floatval($facilityAmount) - floatval($availableLimit)) . '.00';
                
                $availabilityDate = $maturityDate;
                
                $facilityInformations[] = [
                    'facility_code' => $facilityCode,
                    'facility_number' => $facilityNumber,
                    'facility_name' => $facilityName,
                    'principle_type' => $principleType,
                    'islamic_concept' => $islamicConcept,
                    'maturity_date' => $maturityDate,
                    'instrument' => $instrument,
                    'instrument_type' => $instrumentType,
                    'guaranteed' => $guaranteed,
                    'total_guaranteed' => $totalGuaranteed,
                    'indicator' => $indicator,
                    'facility_rating' => $facilityRating,
                    'facility_amount' => $facilityAmount,
                    'available_limit' => $availableLimit,
                    'outstanding_amount' => $outstandingAmount,
                    'trustee_security_agent' => 'AmanahRaya Trustees Berhad',
                    'lead_arranger' => $shortName . ' Investment Bank',
                    'facility_agent' => $shortName . ' Investment Bank',
                    'availability_date' => $availabilityDate,
                    'prepared_by' => 'System',
                    'verified_by' => rand(0, 1) ? 'System Verifier' : null,
                    'remarks' => 'Auto-generated facility information',
                    'approval_datetime' => Carbon::now()->subMonths(rand(1, 12))->format('Y-m-d H:i:s'),
                    'issuer_id' => $issuerId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('facility_informations')->insert($facilityInformations);

        // Seed Related Documents
        $relatedDocuments = [];
        $facilityIds = DB::table('facility_informations')->pluck('id')->toArray();
        
        $documentTypes = [
            'Trust Deed', 'Information Memorandum', 'Pricing Supplement', 
            'Security Agreement', 'Offering Circular', 'Facility Agreement'
        ];
        
        foreach ($facilityIds as $facilityId) {
            // Generate 1-3 documents per facility
            $numDocuments = rand(1, 3);
            $docTypes = array_rand($documentTypes, $numDocuments);
            
            if (!is_array($docTypes)) {
                $docTypes = [$docTypes];
            }
            
            foreach ($docTypes as $typeIndex) {
                $docType = $documentTypes[$typeIndex];
                $facilityInfo = DB::table('facility_informations')
                                ->where('id', $facilityId)
                                ->first(['facility_code']);
                
                $uploadDate = Carbon::now()->subMonths(rand(1, 24))->format('Y-m-d');
                
                $relatedDocuments[] = [
                    'document_name' => $docType,
                    'document_type' => $docType,
                    'upload_date' => $uploadDate,
                    'file_path' => 'documents/' . strtolower(str_replace('-', '_', $facilityInfo->facility_code)) . 
                                '/' . strtolower(str_replace(' ', '_', $docType)) . '.pdf',
                    'facility_id' => $facilityId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('related_documents')->insert($relatedDocuments);

        // Seed Charts
        $charts = [];
        $activeBondIds = DB::table('bonds')
                         ->whereIn('status', ['Active', 'Maturing'])
                         ->pluck('id')
                         ->toArray();
        
        $chartTypes = ['Price History', 'Yield History', 'Trading Volume', 'Spread Analysis'];
        
        foreach ($activeBondIds as $bondId) {
            if (rand(0, 2) > 0) { // 2/3 chance to create chart
                $chartType = $chartTypes[array_rand($chartTypes)];
                
                // Generate chart data based on type
                $chartData = [];
                $startDate = Carbon::now()->subMonths(6);
                
                for ($i = 0; $i < 6; $i++) { // 6 months of data
                    $date = $startDate->copy()->addMonths($i)->format('Y-m-d');
                    
                    if ($chartType == 'Price History') {
                        $value = 100 + (rand(-200, 200) / 100); // 98.00 to 102.00
                        $chartData[] = ['date' => $date, 'price' => $value];
                    } elseif ($chartType == 'Yield History') {
                        $value = 4 + (rand(-100, 100) / 100); // 3.00 to 5.00
                        $chartData[] = ['date' => $date, 'yield' => $value];
                    } elseif ($chartType == 'Trading Volume') {
                        $value = rand(5, 50) * 1000000; // 5M to 50M
                        $chartData[] = ['date' => $date, 'volume' => $value];
                    } else { // Spread Analysis
                        $value = (rand(10, 100) / 100); // 0.10 to 1.00
                        $chartData[] = ['date' => $date, 'spread' => $value];
                    }
                }
                
                $charts[] = [
                    'availability_date' => Carbon::now()->format('Y-m-d'),
                    'approval_date_time' => Carbon::now()->subDays(rand(1, 7))->format('Y-m-d H:i:s'),
                    'chart_type' => $chartType,
                    'chart_data' => json_encode($chartData),
                    'period_from' => $startDate->format('Y-m-d'),
                    'period_to' => Carbon::now()->format('Y-m-d'),
                    'bond_id' => $bondId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('charts')->insert($charts);

        // Seed Trustee Fees
        $trusteeFees = [];
        // Get facility IDs instead of issuer IDs
        $facilityIds = array_values(DB::table('facility_informations')->pluck('id')->toArray());

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $statuses = ['Active', 'Pending', 'Inactive', 'Draft', 'Rejected'];

        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;

        foreach ($facilityIds as $facilityId) {
            // Only create fee for some facilities
            if (rand(0, 1) == 1) { // 50% chance
                // Get facility information for references
                $facility = DB::table('facility_informations')
                    ->join('issuers', 'facility_informations.issuer_id', '=', 'issuers.id')
                    ->where('facility_informations.id', $facilityId)
                    ->select('facility_informations.*', 'issuers.issuer_short_name')
                    ->first();
                
                if (!$facility) {
                    continue;
                }
                
                // Current year fee
                $month = $months[array_rand($months)];
                $date = rand(1, 28);
                $fee1 = rand(30, 80) * 1000;
                $fee2 = $fee1 / 2;
                
                $startDate = Carbon::createFromFormat('Y-m-d', $currentYear . '-' . sprintf("%02d", array_search($month, $months) + 1) . '-' . sprintf("%02d", $date));
                $endDate = $startDate->copy()->addYear()->subDay();
                
                $status = $statuses[array_rand($statuses)];
                $paymentReceived = ($status == 'Active') ? $startDate->copy()->addDays(rand(10, 30))->format('Y-m-d') : null;
                
                $trusteeFees[] = [
                    'month' => $month,
                    'date' => $date,
                    'description' => 'Annual Trustee Fee for ' . $facility->facility_name,
                    'trustee_fee_amount_1' => $fee1 . '.00',
                    'trustee_fee_amount_2' => $fee2 . '.00',
                    'start_anniversary_date' => $startDate->format('Y-m-d'),
                    'end_anniversary_date' => $endDate->format('Y-m-d'),
                    'memo_to_fad' => $startDate->copy()->subDays(rand(5, 15))->format('Y-m-d'),
                    'invoice_no' => 'INV-' . substr($facility->issuer_short_name, 0, 4) . '-' . $currentYear . '-' . $facilityId,
                    'date_letter_to_issuer' => $startDate->copy()->subDays(rand(5, 10))->format('Y-m-d'),
                    'first_reminder' => ($status != 'Active') ? $startDate->copy()->addMonths(1)->format('Y-m-d') : null,
                    'second_reminder' => ($status != 'Active' && rand(0, 1) == 1) ? $startDate->copy()->addMonths(2)->format('Y-m-d') : null,
                    'third_reminder' => null,
                    'payment_received' => $paymentReceived,
                    'tt_cheque_no' => $paymentReceived ? 'TT-' . rand(1000000, 9999999) : null,
                    'memo_receipt_to_fad' => $paymentReceived ? Carbon::parse($paymentReceived)->addDays(rand(3, 7))->format('Y-m-d') : null,
                    'receipt_to_issuer' => $paymentReceived ? Carbon::parse($paymentReceived)->addDays(rand(5, 10))->format('Y-m-d') : null,
                    'receipt_no' => $paymentReceived ? 'RCPT-' . substr($facility->issuer_short_name, 0, 4) . '-' . $currentYear . '-' . $facilityId : null,
                    'prepared_by' => 'System',
                    'verified_by' => ($status == 'Active' || $status == 'Inactive') ? 'System Verifier' : null,
                    'remarks' => 'Auto-generated trustee fee',
                    'approval_datetime' => ($status == 'Active' || $status == 'Inactive') ? $startDate->copy()->format('Y-m-d H:i:s') : null,
                    'status' => $status,
                    'facility_information_id' => $facilityId, // Changed from issuer_id to facility_information_id
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Last year fee (always completed)
                $lastYearMonth = $months[array_rand($months)];
                $lastYearDate = rand(1, 28);
                $lastYearFee1 = rand(30, 80) * 1000;
                $lastYearFee2 = $lastYearFee1 / 2;
                
                $lastYearStartDate = Carbon::createFromFormat('Y-m-d', $lastYear . '-' . sprintf("%02d", array_search($lastYearMonth, $months) + 1) . '-' . sprintf("%02d", $lastYearDate));
                $lastYearEndDate = $lastYearStartDate->copy()->addYear()->subDay();
                $lastYearPaymentReceived = $lastYearStartDate->copy()->addDays(rand(10, 30))->format('Y-m-d');
                
                $trusteeFees[] = [
                    'month' => $lastYearMonth,
                    'date' => $lastYearDate,
                    'description' => 'Annual Trustee Fee for ' . $facility->facility_name . ' (Previous Year)',
                    'trustee_fee_amount_1' => $lastYearFee1 . '.00',
                    'trustee_fee_amount_2' => $lastYearFee2 . '.00',
                    'start_anniversary_date' => $lastYearStartDate->format('Y-m-d'),
                    'end_anniversary_date' => $lastYearEndDate->format('Y-m-d'),
                    'memo_to_fad' => $lastYearStartDate->copy()->subDays(rand(5, 15))->format('Y-m-d'),
                    'invoice_no' => 'INV-' . substr($facility->issuer_short_name, 0, 4) . '-' . $lastYear . '-' . $facilityId,
                    'date_letter_to_issuer' => $lastYearStartDate->copy()->subDays(rand(5, 10))->format('Y-m-d'),
                    'first_reminder' => rand(0, 1) == 1 ? $lastYearStartDate->copy()->addMonths(1)->format('Y-m-d') : null,
                    'second_reminder' => null,
                    'third_reminder' => null,
                    'payment_received' => $lastYearPaymentReceived,
                    'tt_cheque_no' => 'TT-' . rand(1000000, 9999999),
                    'memo_receipt_to_fad' => Carbon::parse($lastYearPaymentReceived)->addDays(rand(3, 7))->format('Y-m-d'),
                    'receipt_to_issuer' => Carbon::parse($lastYearPaymentReceived)->addDays(rand(5, 10))->format('Y-m-d'),
                    'receipt_no' => 'RCPT-' . substr($facility->issuer_short_name, 0, 4) . '-' . $lastYear . '-' . $facilityId,
                    'prepared_by' => 'System',
                    'verified_by' => 'System Verifier',
                    'remarks' => 'Auto-generated trustee fee (previous year)',
                    'approval_datetime' => $lastYearStartDate->copy()->format('Y-m-d H:i:s'),
                    'status' => 'Active',
                    'facility_information_id' => $facilityId, // Changed from issuer_id to facility_information_id
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Only insert if we have records
        if (count($trusteeFees) > 0) {
            DB::table('trustee_fees')->insert($trusteeFees);
        }
        
        // Seed Compliance Covenants
        $complianceCovenants = [];
        $issuerIds = array_values(DB::table('issuers')->pluck('id')->toArray());
        
        // Document statuses (to align with string fields in migration)
        $documentStatuses = ['Received', 'Pending', 'Not Compliant', 'Not Required'];
        
        // Record statuses
        $recordStatuses = ['Draft', 'Active', 'Inactive', 'Pending', 'Rejected'];
        
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        foreach ($issuerIds as $issuerId) {
            // Only create covenant for some issuers
            if (rand(0, 2) > 0) { // 2/3 chance
                // Current year covenant
                $fscr = (rand(120, 180) / 100); // 1.2 to 1.8
                $verifiedBy = rand(0, 2) > 0 ? 'System Verifier' : null; // 2/3 chance to be verified
                
                // Generate random status for documents
                $currentYearDocStatuses = [
                    'audited_financial_statements' => $documentStatuses[array_rand($documentStatuses)],
                    'unaudited_financial_statements' => $documentStatuses[array_rand($documentStatuses)],
                    'compliance_certificate' => $documentStatuses[array_rand($documentStatuses)],
                    'annual_budget' => $documentStatuses[array_rand($documentStatuses)],
                    'computation_of_finance_to_ebitda' => $documentStatuses[array_rand($documentStatuses)],
                    'ratio_information_on_use_of_proceeds' => $documentStatuses[array_rand($documentStatuses)]
                ];
                
                // Assign status randomly from all options for testing purposes
                $status = $recordStatuses[array_rand($recordStatuses)];
                
                $complianceCovenants[] = [
                    'issuer_id' => $issuerId,
                    'financial_year_end' => $currentYear . '-12-31',
                    'audited_financial_statements' => $currentYearDocStatuses['audited_financial_statements'],
                    'unaudited_financial_statements' => $currentYearDocStatuses['unaudited_financial_statements'],
                    'compliance_certificate' => $currentYearDocStatuses['compliance_certificate'],
                    'finance_service_cover_ratio' => (string)$fscr, // Convert to string to match migration
                    'annual_budget' => $currentYearDocStatuses['annual_budget'],
                    'computation_of_finance_to_ebitda' => $currentYearDocStatuses['computation_of_finance_to_ebitda'],
                    'ratio_information_on_use_of_proceeds' => $currentYearDocStatuses['ratio_information_on_use_of_proceeds'],
                    'status' => $status,
                    'prepared_by' => 'System',
                    'verified_by' => $verifiedBy,
                    'remarks' => 'Auto-generated compliance covenant for ' . $currentYear,
                    'approval_datetime' => $verifiedBy ? Carbon::now()->subDays(rand(10, 60))->format('Y-m-d H:i:s') : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                // Last year covenant with mixed statuses for testing
                $lastYearFscr = (rand(120, 180) / 100); // 1.2 to 1.8
                
                $complianceCovenants[] = [
                    'issuer_id' => $issuerId,
                    'financial_year_end' => $lastYear . '-12-31',
                    'audited_financial_statements' => $documentStatuses[array_rand($documentStatuses)],
                    'unaudited_financial_statements' => $documentStatuses[array_rand($documentStatuses)],
                    'compliance_certificate' => $documentStatuses[array_rand($documentStatuses)],
                    'finance_service_cover_ratio' => (string)$lastYearFscr, // Convert to string to match migration
                    'annual_budget' => $documentStatuses[array_rand($documentStatuses)],
                    'computation_of_finance_to_ebitda' => $documentStatuses[array_rand($documentStatuses)],
                    'ratio_information_on_use_of_proceeds' => $documentStatuses[array_rand($documentStatuses)],
                    'status' => $recordStatuses[array_rand($recordStatuses)],
                    'prepared_by' => 'System',
                    'verified_by' => rand(0, 3) > 0 ? 'System Verifier' : null, // 3/4 chance to be verified
                    'remarks' => 'Auto-generated compliance covenant for ' . $lastYear . ' (previous year)',
                    'approval_datetime' => rand(0, 3) > 0 ? Carbon::createFromFormat('Y-m-d', $lastYear . '-12-31')->addDays(rand(15, 45))->format('Y-m-d H:i:s') : null,
                    'created_at' => Carbon::createFromFormat('Y-m-d', $lastYear . '-12-31')->addDays(rand(15, 45)),
                    'updated_at' => Carbon::createFromFormat('Y-m-d', $lastYear . '-12-31')->addDays(rand(15, 45)),
                ];
            }
        }

        DB::table('compliance_covenants')->insert($complianceCovenants);

        // Seed Activity Diaries
        $activityDiaries = [];
        $issuerIds = array_values(DB::table('issuers')->pluck('id')->toArray());

        $activityPurposes = [
            'Annual review meeting with issuer',
            'Coupon payment verification',
            'Trust deed amendment discussion',
            'Compliance certificate review',
            'Quarterly compliance check',
            'Rating update monitoring',
            'Financial statement analysis',
            'Due diligence meeting',
            'Initial documentation review',
            'Covenant structure consultation',
            'Draft term sheet review',
            'Shariah advisor consultation'
        ];

        $activityStatuses = ['pending', 'in_progress', 'completed', 'overdue', 'compiled', 'notification', 'passed'];

        foreach ($issuerIds as $issuerId) {
            // Generate 2-5 activities per issuer
            $numActivities = rand(2, 5);
            $activityIndices = array_rand($activityPurposes, $numActivities);
            
            if (!is_array($activityIndices)) {
                $activityIndices = [$activityIndices];
            }
            
            foreach ($activityIndices as $index) {
                $purpose = $activityPurposes[$index];
                $letterDate = Carbon::now()->subDays(rand(0, 60));
                $dueDate = $letterDate->copy()->addDays(rand(15, 45));
                $status = $activityStatuses[array_rand($activityStatuses)];
                
                // Make activities more realistic based on status
                if ($status == 'completed') {
                    $dueDate = Carbon::now()->subDays(rand(1, 30));
                } elseif ($status == 'overdue') {
                    $dueDate = Carbon::now()->subDays(rand(1, 15));
                } elseif ($status == 'compiled') {
                    $dueDate = Carbon::now()->subDays(rand(5, 25));
                } elseif ($status == 'notification') {
                    $dueDate = Carbon::now()->addDays(rand(5, 15));
                } elseif ($status == 'passed') {
                    $dueDate = Carbon::now()->subDays(rand(10, 40));
                }
                
                $verifiedBy = in_array($status, ['completed', 'compiled', 'passed']) ? 'System Verifier' : null;
                $approvalDateTime = in_array($status, ['completed', 'compiled', 'passed']) ? Carbon::now()->subDays(rand(1, 10)) : null;
                
                // Add extensions with 30% probability
                $hasExtension1 = (rand(1, 10) <= 3);
                $hasExtension2 = $hasExtension1 && (rand(1, 10) <= 3);
                
                $extensionDate1 = null;
                $extensionNote1 = null;
                $extensionDate2 = null;
                $extensionNote2 = null;
                
                if ($hasExtension1) {
                    $extensionDate1 = $dueDate->copy()->addDays(rand(10, 20))->format('Y-m-d');
                    $extensionNote1 = 'Extension requested due to ' . ['internal review', 'documentation delay', 'issuer request', 'market conditions'][rand(0, 3)];
                }
                
                if ($hasExtension2) {
                    $extensionDate2 = Carbon::parse($extensionDate1)->addDays(rand(10, 20))->format('Y-m-d');
                    $extensionNote2 = 'Additional extension required for ' . ['further analysis', 'awaiting board approval', 'regulatory consultation', 'market changes'][rand(0, 3)];
                }
                
                $activityDiaries[] = [
                    'issuer_id' => $issuerId,
                    'purpose' => $purpose,
                    'letter_date' => $letterDate->format('Y-m-d'),
                    'due_date' => $dueDate->format('Y-m-d'),
                    'extension_date_1' => $extensionDate1,
                    'extension_note_1' => $extensionNote1,
                    'extension_date_2' => $extensionDate2,
                    'extension_note_2' => $extensionNote2,
                    'status' => $status,
                    'remarks' => 'Auto-generated activity: ' . $purpose,
                    'prepared_by' => 'System',
                    'verified_by' => $verifiedBy,
                    'approval_datetime' => $approvalDateTime,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('activity_diaries')->insert($activityDiaries);
    }
}