<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $properties = [
            // Portfolio ID 1 (Al Aqar)
            ['name' => 'KUANTAN WELLNESS CENTRE', 'portfolio_id' => 1],
            ['name' => 'KPJ KAJANG SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ SELANGOR SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ PERDANA SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'DAMAI WELLNESS CENTRE', 'portfolio_id' => 1],
            ['name' => 'KPJ PENANG SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ DAMANSARA SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ AMPANG PUTERI SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ PUTERI SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ IPOH SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ KLANG SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ JOHOR SPECIALIST HOSPITAL', 'portfolio_id' => 1],
            ['name' => 'KPJ INTERNATIONAL COLLEGE BUKIT MERTAJAM', 'portfolio_id' => 1],
            ['name' => 'TAIPING MEDICAL CENTRE', 'portfolio_id' => 1],
            ['name' => 'KPJH INTERNATIONAL COLLEGE NILAI', 'portfolio_id' => 1],
            ['name' => 'PROJECT OTTO', 'portfolio_id' => 1],
            ['name' => 'KEDAH MEDICAL CENTRE', 'portfolio_id' => 1],
            ['name' => 'KPJ PASIR GUDANG SH', 'portfolio_id' => 1],
            ['name' => 'KPJ Tawakkal Sh & KPJ Damansara SH', 'portfolio_id' => 1],

            // Portfolio ID 2 (Al Salam)
            ['name' => 'KFC AYER HITAM', 'portfolio_id' => 2],
            ['name' => 'KOMTAR JBCC', 'portfolio_id' => 2],
            ['name' => 'QSR PROPERTIES', 'portfolio_id' => 2],
            ['name' => 'MART KEMPAS', 'portfolio_id' => 2],
            ['name' => 'CENTRE WAREHOUSE', 'portfolio_id' => 2],
            ['name' => 'KFC DT WANGSA MAJU', 'portfolio_id' => 2],
            ['name' => 'CTOS DATA SYSTEMS SDN BHD', 'portfolio_id' => 2],
            ['name' => 'KPJ INTERNATIONAL COLLEGE (MCMH)', 'portfolio_id' => 2],
            ['name' => 'PHD ULU TIRAM', 'portfolio_id' => 2],
            ['name' => 'KOMTAR JBCC & MCHM', 'portfolio_id' => 2],

            // Portfolio ID 3 (AMANAH HARTA TANAH PNB (AHP))
            ['name' => 'CX1, CYBERJAYA', 'portfolio_id' => 3],
            ['name' => 'MYDIN HYPERMARKET, SEREMBAN 2', 'portfolio_id' => 3],

            // Portfolio ID 4 (AMANAH HARTANAH BUMIPUTERA (AHB))
            ['name' => 'PENTADBIR TANAH JOHOR BAHRU', 'portfolio_id' => 4],
        ];

        foreach ($properties as $property) {
            Property::create([
                'portfolio_id' => $property['portfolio_id'],
                'category' => 'Commercial',
                'batch_no' => '1',
                'name' => $property['name'],
                'address' => 'Unknown Address',
                'city' => 'Unknown City',
                'state' => 'Unknown State',
                'country' => 'Malaysia',
                'postal_code' => '00000',
                'land_size' => 0.00,
                'gross_floor_area' => 0.00,
                'usage' => 'Retail',
                'value' => 0.00,
                'ownership' => 'Full',
                'share_amount' => 0.00,
                'market_value' => 0.00,
            ]);
        }
    }
}