<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(fake()->numberBetween(1, 3), true);

        $name = Str::title($name);

        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'description'   => fake()->optional(0.6)->paragraph(fake()->numberBetween(1, 3)), // 60% probabilidad de tener descripción
            'parent_id'     => null,
            'is_visible'    => fake()->boolean(85), // 85% probabilidad de ser visible
        ];
    }
}
