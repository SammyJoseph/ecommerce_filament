@push('css')
<style>
    .brand-slider-container {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    
    .brand-slider-container::before,
    .brand-slider-container::after {
        content: '';
        position: absolute;
        top: 0;
        width: 100px;
        height: 100%;
        z-index: 2;
        pointer-events: none;
    }
    
    .brand-slider-container::before {
        left: 0;
        background: linear-gradient(to right, #fff, transparent);
    }
    
    .brand-slider-container::after {
        right: 0;
        background: linear-gradient(to left, #fff, transparent);
    }
    
    .brand-slider-track {
        display: flex;
        width: max-content;
        animation: brandSlide 25s linear infinite;
    }
    
    .brand-slider-track:hover {
        animation-play-state: paused;
    }
    
    .brand-slide-item {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 40px;
    }
    
    .brand-slide-item img {
        max-height: 60px;
        width: auto;
        object-fit: contain;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: all 0.3s ease;
    }
    
    .brand-slide-item:hover img {
        filter: grayscale(0%);
        opacity: 1;
        transform: scale(1.05);
    }
    
    @keyframes brandSlide {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(calc(-100% / 6));
        }
    }
    
    @media (max-width: 767px) {
        .brand-slide-item {
            padding: 0 25px;
        }
        
        .brand-slide-item img {
            max-height: 45px;
        }
        
        .brand-slider-container::before,
        .brand-slider-container::after {
            width: 50px;
        }
    }
</style>
@endpush

<div class="brand-logo-area pt-100 pb-100">
    <div class="container-fluid px-0">
        <div class="brand-slider-container">
            <div class="brand-slider-track">
                @foreach(range(1, 6) as $i)
                    @forelse($brandLogos as $logo)
                        <div class="brand-slide-item">
                            <img src="{{ asset('storage/'.$logo['image']) }}" alt="Brand Logo">
                        </div>
                    @empty
                        <div class="brand-slide-item">
                            <img src="{{ asset('assets/images/brand-logo/brand-logo-1.png') }}" alt="Brand Logo">
                        </div>
                        <div class="brand-slide-item">
                            <img src="{{ asset('assets/images/brand-logo/brand-logo-2.png') }}" alt="Brand Logo">
                        </div>
                        <div class="brand-slide-item">
                            <img src="{{ asset('assets/images/brand-logo/brand-logo-3.png') }}" alt="Brand Logo">
                        </div>
                        <div class="brand-slide-item">
                            <img src="{{ asset('assets/images/brand-logo/brand-logo-4.png') }}" alt="Brand Logo">
                        </div>
                        <div class="brand-slide-item">
                            <img src="{{ asset('assets/images/brand-logo/brand-logo-5.png') }}" alt="Brand Logo">
                        </div>
                    @endforelse
                @endforeach
            </div>
        </div>
    </div>
</div>