<?php

namespace Database\Factories;

use App\Models\RelatedDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelatedDocumentFactory extends Factory
{
    protected $model = RelatedDocument::class;

    public function definition()
    {
        return [
            'document_name' => $this->faker->word . ' Document',
            'document_type' => $this->faker->randomElement(['PDF', 'Word', 'Excel']),
            'upload_date' => $this->faker->date(),
            'file_path' => '/documents/' . $this->faker->uuid . '.pdf',
            'facility_id' => \App\Models\FacilityInformation::factory(),
        ];
    }
}
