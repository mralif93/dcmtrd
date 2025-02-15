<?php

namespace Database\Factories;

use App\Models\Issuer;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition()
    {
        return [
            'issuer_id' => Issuer::factory(),
            'announcement_date' => $this->faker->dateTimeBetween('-1 year'),
            'category' => $this->faker->randomElement(['Financial', 'Dividend', 'Mergers']),
            'sub_category' => $this->faker->optional()->randomElement(['Interim', 'Final', 'Special']),
            'title' => $this->faker->sentence(8),
            'description' => $this->faker->paragraph(3),
            'content' => $this->faker->text(2000),
            'attachment' => $this->faker->optional()->filePath(),
            'source' => $this->faker->randomElement(['Bursa Malaysia', 'Company Portal']),
        ];
    }
}