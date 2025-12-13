<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\BlogCategory::factory()->count(5)->create();

        \App\Models\Blog::factory()->count(10)->create()->each(function ($blog) use ($categories) {
            $blog->categories()->attach(
                $categories->random(rand(1, 2))->pluck('id')->toArray()
            );

            $imageWidth = 800;
            $imageHeight = 600;
            $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 1000);
            
            // Download image
            $imageContent = file_get_contents($imageUrl);
            $imageName = 'blog/' . \Illuminate\Support\Str::random(40) . '.jpg';
            \Illuminate\Support\Facades\Storage::disk('public')->put($imageName, $imageContent);

            $blog->update(['image' => $imageName]);
        });
    }
}
