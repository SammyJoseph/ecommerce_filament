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

    public function preview($token)
    {
        $data = \Illuminate\Support\Facades\Cache::get('blog_preview_' . $token);

        if (!$data) {
            abort(404, 'Preview expired or invalid.');
        }

        // Hydrate a dummy Blog model with the cached data
        $blog = new Blog($data);
        
        // If we are previewing an existing record, we might want to manually set the ID 
        // in case the view relies on it (though typically show views just use attributes)
        // $blog->id = $data['id'] ?? null; 

        return view('blog.show', compact('blog'));
    }

    public function blogCategoryIndex()
    {
        //
    }

    public function blogCategoryShow(BlogCategory $blogCategory)
    {
        //
    }
}
