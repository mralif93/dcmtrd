<?php

namespace Database\Factories;

use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        return [
            'announcement_date' => $this->faker->date(),
            'category' => $this->faker->randomElement(['Financial', 'Corporate Action', 'General']),
            'sub_category' => $this->faker->word,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'content' => $this->faker->text(500),
            'attachment' => $this->faker->optional()->filePath(),
            'source' => $this->faker->company,
            'issuer_id' => \App\Models\Issuer::factory(),
        ];
    }
}
