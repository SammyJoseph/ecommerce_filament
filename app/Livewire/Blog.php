<?php

namespace App\Livewire;

use App\Models\Blog as ModelsBlog;
use App\Models\BlogCategory;
use Livewire\Component;

use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Blog extends Component
{
    use WithPagination;

    #[Url(as: 'category', except: '')]
    public $categorySlug = '';

    #[Url(except: '')]
    public $search = '';

    public function updatedSearch()
    {
        $this->categorySlug = '';
        $this->resetPage();
    }

    public function filterByCategory($slug)
    {
        $this->search = '';
        if ($this->categorySlug === $slug) {
            $this->categorySlug = '';
        } else {
            $this->categorySlug = $slug;
        }
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $query = ModelsBlog::visible()
            ->with(['categories'])
            ->orderBy('published_at', 'desc');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        } elseif ($this->categorySlug) {
            $query->whereHas('categories', function ($q) {
                $q->where('slug', $this->categorySlug);
            });
        }
        $posts = $query->paginate(6);

        $categories = BlogCategory::withCount(['blogs' => function ($query) {
            $query->visible();
        }])->get();

        $recentPosts = ModelsBlog::visible()->orderBy('published_at', 'desc')->take(3)->get();

        return view('livewire.blog', compact('posts', 'categories', 'recentPosts'));
    }
}
