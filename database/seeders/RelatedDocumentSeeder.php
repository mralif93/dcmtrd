<?php

namespace Database\Seeders;

use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use Illuminate\Database\Seeder;

class RelatedDocumentSeeder extends Seeder
{
    public function run()
    {
        // Create 3-5 documents per facility
        foreach (FacilityInformation::all() as $facility) {
            RelatedDocument::factory()
                ->count(rand(3, 5))
                ->create(['facility_id' => $facility->id]);
        }
    }
}