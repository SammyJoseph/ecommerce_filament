<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductReviews extends Component
{
    public Product $product;
    public $rating = 5;
    public $comment = '';

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:5|max:1000',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function getCanReviewProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();

        // Check if user has already reviewed this product
        if ($this->product->reviews()->where('user_id', $user->id)->exists()) {
            return false;
        }

        // Check if user has purchased the product and order is delivered
        return $user->orders()
            ->where('status', 'delivered')
            ->whereHas('orderItems', function ($query) {
                $query->where('product_id', $this->product->id);
            })
            ->exists();
    }

    public function submitReview()
    {
        if (!$this->canReview) {
            return;
        }

        $this->validate();

        $this->product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_visible' => true,
        ]);

        $this->reset(['rating', 'comment']);
        
        // Dispatch event for UI feedback (optional, handled by view logic)
        session()->flash('message', 'Thank you for your review!');
    }

    public function render()
    {
        $reviews = $this->product->reviews()
            ->where('is_visible', true)
            ->with('user')
            ->latest()
            ->get();

        return view('livewire.product-reviews', [
            'reviews' => $reviews
        ]);
    }
}
