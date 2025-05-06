<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Tenant;
use App\Models\Property;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenancies = [
            // KOMTAR JBCC
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'JOHOR CORPORATION'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Al Bagus Food and Beverage Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'BNX Delight Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'BNX Takahara Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Caring Pharmacy Retail Management Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Chamelon Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Chrisna Jenio Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Era Sag (JB) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Eyeflex Optometrix Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'F.O.S Apparel Group Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Grand Companies Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'KPK Quantity Surveyors (Semenanjung) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Habib Jewels Franchise Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'JPS Fashions (Malaysia) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'La Mior Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'LAC Global Brands (Malaysia) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Luxe Hair Group Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Johor Plantations Group Berhad'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Yayasan Johor Corporation'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Maxenta Cosmeceuticals Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Azmi & Associates'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'TT Dotcom Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Howden Insurance Brokers Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Cemara Astka Solutions Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Mynews Retails Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Nails Studio JBCC'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'NDIS Group Development'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Orax Enterprise'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Padini Dot Com Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Richeese Factory Malaysia Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'SEKVS Trading Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Willis (Malaysia) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Luggage Lockers PLT'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Sorella (M) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Tea Garden Restaurant (MY) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'TEC Malaysia Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Azman, Wong, Salleh & Co'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Mohd Akhir & Partners'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Thai Odyssey Group Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'The Coffee Bean & Tea Leaf (M) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'TMT Delight Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Vincci Ladies’ Specialties Centre Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Vitality Boost Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Vivo Food Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Yee Fong Hung (M) Sdn Bhd'],
            ['property_name' => 'KOMTAR JBCC', 'tenant_name' => 'Yung Fa Retail Sdn Bhd'],
            // Property: MART KEMPAS
            ['property_name' => 'MART KEMPAS', 'tenant_name' => 'Family Jaya Enterprise'],
        ];

        foreach ($tenancies as $data) {
            $property = Property::where('name', $data['property_name'])->first();

            if ($property) {
                Tenant::create([
                    'property_id' => $property->id,
                    'name' => $data['tenant_name'],
                    'contact_person' => 'N/A',
                    'email' => 'na@gmail.com',
                    'phone' => '000-0000000',
                    'commencement_date' => Carbon::parse('2023-01-01'),
                    'expiry_date' => Carbon::parse('2026-01-01'),
                    'status' => 'Draft',
                ]);
            }
        }
    }
}
