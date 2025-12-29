<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Wishlist;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

class Shop extends Component
{
    use WithPagination;

    public $search = '';
    public $category_slugs = '';
    public $min_price = 0;
    public $max_price;
    public $price_range_max;
    public $per_page = 12;
    public $sort_by = '';
    public $on_sale = false;
    public $is_new = false;
    public $wishlistProductIds = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'category_slugs' => ['except' => '', 'as' => 'categories'],
        'min_price' => ['except' => 0],
        'max_price' => ['except' => null],
        'per_page' => ['except' => 12],
        'sort_by' => ['except' => ''],
        'on_sale' => ['except' => false],
        'is_new' => ['except' => false],
    ];

    public function mount()
    {
        $this->price_range_max = ceil(Product::query()->max(DB::raw('CASE WHEN sale_price > 0 AND sale_price < price THEN sale_price ELSE price END')) ?? 1000);
        $this->max_price = request()->input('max_price', $this->price_range_max);
        $this->loadWishlist();
    }

    public function toggleWishlist($productId)
    {
        $product = Product::findOrFail($productId);
    
        $cartItem = Cart::instance('wishlist')->content()->firstWhere('id', $productId);
        
        if ($cartItem) {
            Cart::instance('wishlist')->remove($cartItem->rowId);
        } else {
            Cart::instance('wishlist')->add([
                'id'    => $product->id,
                'name'  => $product->name,
                'qty'   => 1,
                'price' => $product->price,
                'options' => [
                    'image' => $product->getFirstMediaUrl('product_images', 'preview'),
                ],
            ]);
        }

        $this->storeCart();
        $this->loadWishlist();
        $this->dispatch('wishlist-updated');
    }

    private function loadWishlist()
    {
        if (Auth::check()) {
            Cart::instance('wishlist')->restore(Auth::id());
        }
        
        $this->wishlistProductIds = Cart::instance('wishlist')->content()->pluck('id')->toArray();
    }

    private function storeCart()
    {
        if (Auth::check()) {
            Cart::instance('wishlist')->store(Auth::id());
        }
    }

    public function filterByCategory($slug)
    {
        if ($this->category_slugs == $slug) {
            $this->category_slugs = '';
        } else {
            $this->category_slugs = $slug;
        }
        
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedOnSale()
    {
        $this->resetPage();
    }

    public function updatedIsNew()
    {
        $this->resetPage();
    }

    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->where('is_visible', true);
        }])->get();

        $on_sale_count = Product::query()->where('is_visible', true)
            ->where('sale_price', '>', 0)
            ->whereColumn('sale_price', '<', 'price')
            ->count();

        $is_new_count = Product::query()->where('is_visible', true)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $products = Product::query()
            ->with(['categories', 'tags', 'media'])
            ->withCount(['reviews' => function ($query) {
                $query->where('is_visible', true);
            }])
            ->withAvg(['reviews' => function ($query) {
                $query->where('is_visible', true);
            }], 'rating')
            ->where('is_visible', true)
            ->when($this->search, function (Builder $query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->category_slugs, function (Builder $query) {
                $slugs = explode(',', $this->category_slugs);
                foreach ($slugs as $slug) {
                    $query->whereHas('categories', function (Builder $query) use ($slug) {
                        $query->where('slug', $slug);
                    });
                }
            })
            ->when($this->on_sale, function (Builder $query) {
                $query->where('sale_price', '>', 0)
                      ->whereColumn('sale_price', '<', 'price');
            })
            ->when($this->is_new, function (Builder $query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })
            ->where(function (Builder $query) {
                // Filter simple products
                $query->where(function (Builder $q) {
                    $q->where(function (Builder $saleQ) {
                        $saleQ->where('sale_price', '>', 0)
                            ->whereColumn('sale_price', '<', 'price')
                            ->whereBetween('sale_price', [$this->min_price, $this->max_price]);
                    })->orWhere(function (Builder $regularQ) {
                        $regularQ->where(function (Builder $check) {
                            $check->where('sale_price', '<=', 0)
                                ->orWhereNull('sale_price')
                                ->orWhereColumn('sale_price', '>=', 'price');
                        })->whereBetween('price', [$this->min_price, $this->max_price]);
                    });
                })
                // Filter products with variants
                ->orWhereHas('variants', function (Builder $variantQ) {
                    $variantQ->where('is_visible', true)
                        ->whereHas('sizes', function (Builder $sizeQ) {
                            $sizeQ->where(function (Builder $saleQ) {
                                $saleQ->where('sale_price', '>', 0)
                                    ->whereBetween('sale_price', [$this->min_price, $this->max_price]);
                            })->orWhere(function (Builder $regularQ) {
                                $regularQ->where(function (Builder $check) {
                                    $check->where('sale_price', '<=', 0)
                                        ->orWhereNull('sale_price');
                                })->whereBetween('price', [$this->min_price, $this->max_price]);
                            });
                        });
                });
            })
            ->when($this->sort_by, function (Builder $query) {
                switch ($this->sort_by) {
                    case 'price_low':
                        $query->orderByRaw('CASE WHEN sale_price > 0 AND sale_price < price THEN sale_price ELSE price END ASC');
                        break;
                    case 'price_high':
                        $query->orderByRaw('CASE WHEN sale_price > 0 AND sale_price < price THEN sale_price ELSE price END DESC');
                        break;
                }
            })
            ->paginate($this->per_page);

        return view('livewire.shop', compact('products', 'categories', 'on_sale_count', 'is_new_count'));
    }
}
