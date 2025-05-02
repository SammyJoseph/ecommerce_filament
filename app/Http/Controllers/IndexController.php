<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
}
