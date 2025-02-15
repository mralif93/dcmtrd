<?php

namespace Database\Factories;

use App\Models\FacilityInformation;
use App\Models\RelatedDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelatedDocumentFactory extends Factory
{
    protected $model = RelatedDocument::class;

    public function definition()
    {
        return [
            'document_name' => $this->faker->word . ' Document',
            'document_type' => $this->faker->randomElement(['Contract', 'Report', 'Certificate', 'Agreement']),
            'upload_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'file_path' => $this->faker->filePath(), // Simulate file storage path
            'facility_id' => FacilityInformation::factory(),
        ];
    }
}