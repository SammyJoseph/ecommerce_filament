<style>
    .custom-slide-btn {
        background-color: var(--btn-bg, #000000) !important;
        color: var(--btn-color, #ffffff) !important;
        border-color: var(--btn-bg, #000000) !important;
    }
    .custom-slide-btn:hover {
        background-color: var(--btn-hover-bg, #ff2f2f) !important;
        color: var(--btn-hover-color, #ffffff) !important;
        border-color: var(--btn-hover-bg, #ff2f2f) !important;
    }
    .slider-ornament {
        position: absolute;
        right: 0px;
        top: 50%;
        transform: translateY(-50%) rotate(90deg);
        opacity: 0.07;
        pointer-events: none;
        z-index: 1;
        width: 500px;
        height: auto;
    }
    .slider-ornament-left {
        position: absolute;
        left: -150px;
        bottom: 80px;
        opacity: 0.4;
        pointer-events: none;
        z-index: 0;
        width: 600px;
        height: auto;
    }
    @media only screen and (max-width: 767px) {
        .slider-ornament {
            width: 320px;
            right: -60px;
            opacity: 0.04;
        }
        .slider-ornament-left {
            width: 180px;
            left: 10px;
            bottom: 10px;
            opacity: 0.08;
        }
    }
</style>
<div class="slider-area" style="position: relative; background-color: {{ $generalSettings->main_background_color }}; overflow: hidden;">
    <!-- Background Ornament (Marca Perú) -->
    <div class="slider-ornament">
        <img src="{{ asset('assets/images/slider/marca-peru.png') }}" alt="Marca Perú" style="width: 100%; height: auto;">
    </div>
    <!-- Background Ornament (Flor Cantuta) -->
    <div class="slider-ornament-left">
        <img src="{{ asset('assets/images/slider/flor-cantuta.png') }}" alt="Flor Cantuta" style="width: 100%; height: auto;">
    </div>
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
                                    class="animated btn-1-padding-1 custom-slide-btn" 
                                    href="{{ $slide->button_link }}"
                                    style="
                                        @if($slide->button_bg_color) --btn-bg: {{ $slide->button_bg_color }}; @endif
                                        @if($slide->button_hover_bg_color) --btn-hover-bg: {{ $slide->button_hover_bg_color }}; @endif
                                        @if($slide->button_text_color) --btn-color: {{ $slide->button_text_color }}; @endif
                                        @if($slide->button_hover_text_color) --btn-hover-color: {{ $slide->button_hover_text_color }}; @endif
                                    "
                                >
                                    {{ $slide->button_text }}
                                </a>
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