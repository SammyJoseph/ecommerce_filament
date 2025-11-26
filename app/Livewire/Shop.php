<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class Shop extends Component
{
    use WithPagination;

    public $search = '';
    public $category_slug = '';
    public $min_price = 0;
    public $max_price;
    public $price_range_max;

    protected $queryString = [
        'search' => ['except' => ''],
        'category_slug' => ['except' => ''],
        'min_price' => ['except' => 0],
        'max_price' => ['except' => null],
    ];

    public function mount()
    {
        $this->price_range_max = ceil(Product::query()->max(DB::raw('CASE WHEN sale_price > 0 AND sale_price < price THEN sale_price ELSE price END')) ?? 1000);
        $this->max_price = request()->input('max_price', $this->price_range_max);
    }

    public function filterByCategory($slug)
    {
        $this->category_slug = $slug == $this->category_slug ? '' : $slug;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::withCount('products')->get();

        $products = Product::query()
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->category_slug, function (Builder $query) {
                $query->whereHas('category', function (Builder $query) {
                    $query->where('slug', $this->category_slug);
                });
            })
            ->where(function (Builder $query) {
                $query->where(function (Builder $q) {
                    $q->where('sale_price', '>', 0)
                        ->whereColumn('sale_price', '<', 'price')
                        ->whereBetween('sale_price', [$this->min_price, $this->max_price]);
                })->orWhere(function (Builder $q) {
                    $q->where(function (Builder $q2) {
                        $q2->where('sale_price', '<=', 0)
                            ->orWhereNull('sale_price')
                            ->orWhereColumn('sale_price', '>=', 'price');
                    })->whereBetween('price', [$this->min_price, $this->max_price]);
                });
            })
            ->paginate(12);

        return view('livewire.shop', compact('products', 'categories'));
    }
}
