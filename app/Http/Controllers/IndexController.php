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
            $query->take(10); // takes 10 products per category
        }])->take(5)->get(); // takes 5 categories

        return view('index', compact('categories'));
    }

    public function index2()
    {
        $categories = Category::with(['products' => function($query) {
            $query->take(10);
        }])->take(5)->get();

        return view('index2', compact('categories'));
    }

    public function productDetails(Product $product)
    {
        return view('product-details', compact('product'));
    }
}
