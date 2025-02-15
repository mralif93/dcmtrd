<?php

namespace Database\Seeders;

use App\Models\Issuer;
use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        Issuer::all()->each(function ($issuer) {
            Announcement::factory()
                ->count(rand(5, 10))
                ->create(['issuer_id' => $issuer->id]);
        });
    }
}