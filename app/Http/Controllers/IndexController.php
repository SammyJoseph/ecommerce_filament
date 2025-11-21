<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $categories = Category::with(['products' => function($query) {
            $query->take(10)->with(['variants' => function($q) {
                $q->where('is_visible', true)->with(['color', 'sizes.size', 'media']);
            }]);
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

        // Get related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_visible', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('product.product-details', compact('product', 'variantCombinations', 'relatedProducts'));
    }

    public function myAccount()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('user.my-account', compact('user', 'orders'));
    }

    public function orderDetails(Order $order)
    {
        $user = auth()->user();

        if ($order->user_id !== $user->id) {
            abort(403);
        }

        $order->load('orderItems.product');
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();

        return view('user.my-account', compact('user', 'orders', 'order'));
    }
}
