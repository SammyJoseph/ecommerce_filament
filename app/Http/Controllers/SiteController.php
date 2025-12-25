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
            $query->take(10)->with(['variants' => function($q) {
                $q->where('is_visible', true)->with(['color', 'sizes.size', 'media']);
            }]);
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
            }
        ]);

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

        return view('product.product-details', compact('product', 'variantCombinations', 'relatedProducts'));
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
