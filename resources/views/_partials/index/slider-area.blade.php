<div class="slider-area bg-gray">
    <div class="hero-slider-active-1 hero-slider-pt-1 nav-style-1 dot-style-1">
        @foreach(\App\Models\HeroSlide::active()->ordered()->get() as $slide)
        <div class="single-hero-slider single-animation-wrap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="hero-slider-content-1 hero-slider-content-1-pt-1 slider-animated-1">
                            @if($slide->subtitle)
                                <h4 class="animated">{{ $slide->subtitle }}</h4>
                            @endif
                            <h1 class="animated">{!! nl2br(e($slide->title)) !!}</h1>
                            @if($slide->description)
                                <p class="animated">{{ $slide->description }}</p>
                            @endif
                            @if($slide->button_text && $slide->button_link)
                            <div class="btn-style-1">
                                <a onclick="event.preventDefault(); document.getElementById('featured-products').scrollIntoView({ behavior: 'smooth' })"
                                    class="animated btn-1-padding-1" href="{{ $slide->button_link }}">{{ $slide->button_text }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="hero-slider-img-1 slider-animated-1">
                            @if($slide->hasMedia('hero_slides'))
                                <img class="animated" src="{{ $slide->getFirstMediaUrl('hero_slides') }}" alt="{{ $slide->title }}">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>