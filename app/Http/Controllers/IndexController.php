<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->take(10);
        }])->take(5)->get();

        return view('index', compact('categories'));
    }

    public function productDetails(Product $product)
    {
        $product->load([
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

        return view('product.product-details', compact('product', 'variantCombinations'));
    }
}
