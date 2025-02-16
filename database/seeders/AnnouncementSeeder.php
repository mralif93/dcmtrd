<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\Issuer;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $issuers = Issuer::all();

        foreach ($issuers as $issuer) {
            Announcement::factory()->count(3)->create([
                'issuer_id' => $issuer->id,
            ]);
        }
    }
}