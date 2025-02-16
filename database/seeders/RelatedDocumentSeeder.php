<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RelatedDocument;
use App\Models\FacilityInformation;

class RelatedDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facilities = FacilityInformation::all();

        foreach ($facilities as $facility) {
            RelatedDocument::factory()->count(2)->create([
                'facility_id' => $facility->id,
            ]);
        }
    }
}