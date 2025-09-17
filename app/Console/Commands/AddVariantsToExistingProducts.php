<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AddVariantsToExistingProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-variants-to-existing-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add variants and gallery images to existing products';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to add variants and gallery images to existing products...');

        $products = Product::all();
        $totalProducts = $products->count();
        $this->info("Found {$totalProducts} products to process");

        $progressBar = $this->output->createProgressBar($totalProducts);
        $progressBar->start();

        foreach ($products as $product) {
            try {
                // Add gallery images if product doesn't have enough
                $currentImageCount = $product->getMedia('product_images')->count();

                if ($currentImageCount < 3) {
                    $imagesToAdd = 3 - $currentImageCount;
                    $this->info("Adding {$imagesToAdd} gallery images to product: {$product->name}");

                    for ($i = 0; $i < $imagesToAdd; $i++) {
                        $imageWidth = 800;
                        $imageHeight = 600;
                        $imageUrl = 'https://picsum.photos/' . $imageWidth . '/' . $imageHeight . '?random=' . rand(1, 1000);

                        $product->addMediaFromUrl($imageUrl)
                            ->preservingOriginal()
                            ->toMediaCollection('product_images');
                    }
                }

                // Add variants if product doesn't have any, and randomly decide if it should have variants
                $currentVariantCount = $product->variants()->count();

                if ($currentVariantCount === 0) {
                    // 30% chance of adding variants to a product
                    if (rand(1, 100) <= 30) {
                        $variantCount = rand(1, 5);
                        $this->info("Adding {$variantCount} variants to product: {$product->name}");

                        Variant::factory($variantCount)->create([
                            'product_id' => $product->id,
                        ]);
                        
                        // Set product price to null since it now has variants
                        $product->update(['price' => null]);
                    } else {
                        // Ensure product has a price if it doesn't have variants
                        if ($product->price === null) {
                            $price = rand(100, 900) + (rand(0, 99) / 100);
                            $product->update(['price' => $price]);
                        }
                        $this->info("Product {$product->name} will not have variants");
                    }
                }

            } catch (\Exception $e) {
                $this->error("Failed to process product ID {$product->id}: " . $e->getMessage());
                Log::error("Failed to add variants/images for product ID {$product->id}: " . $e->getMessage());
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info('✅ Successfully processed all existing products!');
        $this->info('Each product now has:');
        $this->info('- 3 gallery images');
        $this->info('- Some products have 1-5 variants with their own images, others have no variants');
    }
}
