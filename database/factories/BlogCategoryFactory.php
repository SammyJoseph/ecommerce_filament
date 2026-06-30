<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        return [
            'name' => [
                'es' => ucfirst($name),
                'fr' => ucfirst($name) . ' (FR)',
            ],
            'slug' => [
                'es' => Str::slug($name),
                'fr' => Str::slug($name) . '-fr',
            ],
            'description' => [
                'es' => $this->faker->sentence,
                'fr' => $this->faker->sentence . ' (FR)',
            ],
            'is_visible' => true,
        ];
    }
}
