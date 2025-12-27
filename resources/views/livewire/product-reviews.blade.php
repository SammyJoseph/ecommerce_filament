<div>
    <div class="review-wrapper">
        <h2>{{ $reviews->count() }} reviews for {{ $product->name }}</h2>
        @forelse($reviews as $review)
            <div wire:key="review-{{ $review->id }}" class="single-review tw-justify-between tw-items-start {{ ($isEditing && auth()->id() === $review->user_id) ? 'tw-hidden' : '' }}">
                <div class="tw-flex">
                    <div class="review-img">
                        <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}">
                    </div>
                    <div class="review-content">
                        <div class="review-top-wrap tw-space-x-2">
                            <div class="review-name">
                                <h5>
                                    <span>{{ $review->user->name }}</span> - {{ $review->created_at->format('M d, Y') }}                                
                                </h5>
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
                @if(auth()->id() === $review->user_id)
                    <button wire:click="editReview({{ $review->id }})" class="tw-text-sm !tw-text-blue-500 hover:tw-underline tw-ml-2 tw-bg-transparent tw-border-0 tw-cursor-pointer">Editar</button>
                @endif
            </div>
        @empty
            <p>No reviews yet.</p>
        @endforelse
    </div>

    <div class="ratting-form-wrapper">
        <span>{{ $isEditing ? 'Edita tu reseña' : 'Añade una reseña' }}</span>
        
        @auth
            @if($this->hasReviewed && !$this->isEditing)
                <div class="tw-flex tw-items-center tw-p-4 tw-mt-4 tw-text-sm tw-text-green-800 tw-border tw-border-green-300 tw-rounded-lg tw-bg-green-50 dark:tw-bg-gray-800 dark:tw-text-green-400 dark:tw-border-green-800" role="alert">
                    <svg class="tw-shrink-0 tw-inline tw-w-4 tw-h-4 tw-me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="tw-sr-only">Info</span>
                    <div>
                        {{ session('message', 'Ya has calificado este producto.') }}
                    </div>
                </div>
            @elseif($this->canReview)
                <div class="ratting-form">
                    <form wire:submit.prevent="submitReview">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="rating-form-style mb-20">
                                    <p>Hola, {{ auth()->user()->name }}. Déjame saber tu opinión sobre este producto.</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label>Tu calificación <span>*</span></label>
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
                                    <label>Tu comentario <span>*</span></label>
                                    <textarea wire:model="comment"></textarea>
                                    @error('comment') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-submit">
                                    <input type="submit" value="{{ $isEditing ? 'Actualizar' : 'Publicar' }}">
                                </div>
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
