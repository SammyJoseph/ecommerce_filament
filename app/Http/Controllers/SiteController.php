<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;

class SiteController extends Controller
{    
    public function index(): View
    {
        $categories = Category::with(['products' => function($query) {
            $query->take(10)
                ->with(['tags', 'variants' => function($q) {
                    $q->where('is_visible', true)->with(['color', 'sizes.size', 'media']);
                }])
                ->withCount(['reviews' => function ($q) {
                    $q->where('is_visible', true);
                }])
                ->withAvg(['reviews' => function ($q) {
                    $q->where('is_visible', true);
                }], 'rating');
        }])->take(5)->get();

        $settings = app(\App\Settings\HomePageSettings::class);
        $instagramItems = $settings->instagram_items ?? [];
        $brandLogos = $settings->brand_logos ?? [];

        return view('index', compact('categories', 'settings', 'instagramItems', 'brandLogos'));
    }

    public function productDetails(Product $product): View
    {
        $product->load([
            'categories',
            'variants' => function($query) {
                $query->where('is_visible', true)
                      ->with(['media', 'options.option', 'options']);
            },
            'options.values.variants' => function($query) {
                $query->where('is_visible', true);
            },
            'reviews' => function($query) {
                $query->where('is_visible', true);
            }
        ]);

        // Calculate average rating and review count
        $averageRating = $product->reviews->avg('rating') ?? 0;
        $reviewCount = $product->reviews->count();

        // Get variant combinations for interactive selection
        $variantCombinations = $product->getVariantCombinations();

        // Get related products from the same category
        $relatedProducts = Product::whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->where('id', '!=', $product->id)
            ->where('is_visible', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('product.product-details', compact('product', 'variantCombinations', 'relatedProducts', 'averageRating', 'reviewCount'));
    }    

    public function wishlist(): View
    {
        return view('product.wishlist');
    }

    public function shop(): View
    {
        return view('shop');
    }

    public function about(): View
    {
        return view('about');
    }

    public function contact(): View
    {
        return view('contact');
    }
}
