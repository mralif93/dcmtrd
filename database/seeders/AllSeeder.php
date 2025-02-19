<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 10 issuers
        \App\Models\Issuer::factory(15)->create()->each(function ($issuer) {
            
            // Create 5 bonds for each issuer
            \App\Models\Bond::factory(5)->create(['issuer_id' => $issuer->id])
                ->each(function ($bond) {
                    
                    // Create 3 rating movements per bond
                    \App\Models\RatingMovement::factory(3)->create(['bond_id' => $bond->id]);
                    
                    // Create 5 payment schedules per bond
                    \App\Models\PaymentSchedule::factory(5)->create(['bond_id' => $bond->id]);
                    
                    // Create redemption with related records
                    \App\Models\Redemption::factory()->create(['bond_id' => $bond->id])
                        ->each(function ($redemption) {
                            // 3 call schedules per redemption
                            \App\Models\CallSchedule::factory(3)->create(['redemption_id' => $redemption->id]);
                            // 2 lockout periods per redemption
                            \App\Models\LockoutPeriod::factory(2)->create(['redemption_id' => $redemption->id]);
                        });
                    
                    // Create 10 trading activities per bond
                    \App\Models\TradingActivity::factory(10)->create(['bond_id' => $bond->id]);
                    
                    // Create 2 charts per bond
                    \App\Models\Chart::factory(2)->create(['bond_id' => $bond->id]);
                });

            // Create 5 announcements per issuer
            \App\Models\Announcement::factory(5)->create(['issuer_id' => $issuer->id]);
            
            // Create 3 facilities per issuer with documents
            \App\Models\FacilityInformation::factory(3)->create(['issuer_id' => $issuer->id])
                ->each(function ($facility) {
                    // 2 related documents per facility
                    \App\Models\RelatedDocument::factory(2)->create(['facility_id' => $facility->id]);
                });
        });

        // Add any additional seeders if needed
    }
}
