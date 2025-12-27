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
    public $reviewSubmitted = false;
    public $isEditing = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:5|max:1000',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function getHasReviewedProperty()
    {
        if ($this->reviewSubmitted) {
            return true;
        }

        if (!Auth::check()) {
            return false;
        }

        return $this->product->reviews()->where('user_id', Auth::id())->exists();
    }

    public function getCanReviewProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        // Check if user has already reviewed this product
        if ($this->hasReviewed && !$this->isEditing) {
            return false;
        }

        // Check if user has purchased the product and order is delivered
        return Auth::user()->orders()
            ->where('status', 'delivered')
            ->whereHas('orderItems', function ($query) {
                $query->where('product_id', $this->product->id);
            })
            ->exists();
    }

    public function editReview($reviewId)
    {
        $review = $this->product->reviews()->where('id', $reviewId)->where('user_id', Auth::id())->first();

        if ($review) {
            $this->rating = $review->rating;
            $this->comment = $review->comment;
            $this->isEditing = true;
            $this->reviewSubmitted = false;
        }
    }

    public function submitReview()
    {
        if (!$this->isEditing && !$this->canReview) {
            return;
        }
        $this->validate();

        if ($this->isEditing) {
            $this->product->reviews()
                ->where('user_id', Auth::id())
                ->update([
                    'rating' => $this->rating,
                    'comment' => $this->comment,
                ]);

            session()->flash('message', 'Tu reseña ha sido actualizada!');
        } else {

            $this->product->reviews()->create([
                'user_id' => Auth::id(),
                'rating' => $this->rating,
                'comment' => $this->comment,
                'is_visible' => true,
            ]);
            session()->flash('message', 'Gracias por tu reseña!');
        }

        $this->reviewSubmitted = true;
        $this->isEditing = false;
        $this->reset(['rating', 'comment']);
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
