<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'content' => [
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => '<p>' . $this->faker->paragraph() . '</p>',
                    ],
                ],
                [
                    'type' => 'quote',
                    'data' => [
                        'text' => $this->faker->sentence(),
                        'author' => $this->faker->name(),
                    ],
                ],
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => '<p>' . $this->faker->paragraph() . '</p>',
                    ],
                ],
                [
                    'type' => 'two_images',
                    'data' => [
                        'image_left' => $this->createImage(),
                        'image_right' => $this->createImage(),
                        'caption' => $this->faker->sentence(),
                    ],
                ],
                [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => '<p>' . $this->faker->paragraph() . '</p>',
                    ],
                ],
            ],
            'is_visible' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    private function createImage(): string
    {
        $dir = storage_path('app/public/blog-content');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = \Illuminate\Support\Str::random(30) . '.jpg';
        $filepath = $dir . '/' . $filename;

        // Try generation with GD for speed and reliability
        if (extension_loaded('gd')) {
            $width = 640;
            $height = 480;
            $image = imagecreatetruecolor($width, $height);
            $color = imagecolorallocate($image, rand(50, 200), rand(50, 200), rand(50, 200));
            imagefill($image, 0, 0, $color);
            
            // Add some text
            $textColor = imagecolorallocate($image, 255, 255, 255);
            imagestring($image, 5, 50, $height / 2, "Blog Image Placeholder", $textColor);
            
            imagejpeg($image, $filepath);
            
            return 'blog-content/' . $filename;
        }

        // Fallback to Faker if GD is missing (though unconventional)
        $fakerImage = $this->faker->image($dir, 640, 480, null, false);
        if ($fakerImage) {
            return 'blog-content/' . $fakerImage;
        }

        // Ultimate fallback
        file_put_contents($filepath, 'placeholder');
        return 'blog-content/' . $filename;
    }
}
