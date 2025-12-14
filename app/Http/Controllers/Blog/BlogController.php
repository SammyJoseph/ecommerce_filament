<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {            
        return view('blog.index');
    }

    public function show(Blog $blog)
    {
        return view('blog.show', compact('blog'));
    }

    public function blogCategoryIndex()
    {
        return view('blog.category.index');
    }

    public function blogCategoryShow(BlogCategory $blogCategory)
    {
        return view('blog.category.show', compact('blogCategory'));
    }
}
