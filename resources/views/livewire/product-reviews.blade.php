<div>
    <div class="review-wrapper">
        <h2>{{ $reviews->count() }} reviews for {{ $product->name }}</h2>
        @forelse($reviews as $review)
            <div class="single-review">
                <div class="review-img">
                    <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}">
                </div>
                <div class="review-content">
                    <div class="review-top-wrap">
                        <div class="review-name">
                            <h5><span>{{ $review->user->name }}</span> - {{ $review->created_at->format('M d, Y') }}</h5>
                        </div>
                        <div class="review-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'yellow icon_star' : 'icon_star_alt' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>

    <div class="ratting-form-wrapper">
        <span>Add a Review</span>
        
        @auth
            @if($this->canReview)
                <div class="ratting-form">
                    <form wire:submit.prevent="submitReview">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="rating-form-style mb-20">
                                    <label>Name <span>*</span></label>
                                    <input type="text" value="{{ auth()->user()->name }}" readonly disabled style="background-color: #f5f5f5; cursor: not-allowed;">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div x-data="{ tempRating: 0, rating: @entangle('rating') }" class="star-box-wrap tw-flex tw-gap-2">
                                    <div class="single-ratting-star tw-flex tw-gap-1">
                                        <template x-for="star in 5">
                                            <button type="button" 
                                                @click="rating = star"
                                                @mouseenter="tempRating = star"
                                                @mouseleave="tempRating = 0"
                                                class="tw-bg-transparent tw-border-0 tw-p-0 tw-cursor-pointer focus:tw-outline-none"
                                            >
                                                <i :class="(tempRating > 0 ? star <= tempRating : star <= rating) 
                                                            ? 'icon_star !tw-text-yellow-400' 
                                                            : 'icon_star_alt tw-text-gray-400'"
                                                   class="tw-text-xl tw-transition-colors tw-duration-200"></i>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="rating-form-style mb-20">
                                    <label>Your review <span>*</span></label>
                                    <textarea wire:model="comment"></textarea>
                                    @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-submit">
                                    <input type="submit" value="Submit">
                                </div>
                                @if (session()->has('message'))
                                    <div class="alert alert-success mt-3">
                                        {{ session('message') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <p>You must have purchased this product and it must be delivered to leave a review.</p>
            @endif
        @else
            <p>Please <a href="{{ route('login') }}">login</a> to leave a review.</p>
        @endauth
    </div>
</div>
