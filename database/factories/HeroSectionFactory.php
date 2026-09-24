<?php

namespace Database\Factories;

use App\Models\HeroSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroSection>
 */
class HeroSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(12),
        ];
    }
}
