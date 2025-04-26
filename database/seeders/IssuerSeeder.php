<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IssuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

        foreach ($issuers as $issuer) {
            DB::table('issuers')->insert([
                'issuer_short_name' => $issuer['issuer_short_name'],
                'issuer_name' => $issuer['issuer_name'],
                'registration_number' => $issuer['registration_number'],
                'debenture' => '',
                'trustee_role_1' => '',
                'trustee_role_2' => '',
                'trust_deed_date' => null,
                'trust_amount_escrow_sum' => null,
                'no_of_share' => null,
                'outstanding_size' => null,
                'status' => 'Draft',
                'prepared_by' => null,
                'verified_by' => null,
                'remarks' => null,
                'approval_datetime' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}